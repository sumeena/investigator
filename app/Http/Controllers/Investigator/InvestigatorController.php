<?php

namespace App\Http\Controllers\Investigator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Investigator\InvestigatorProfileRequest;
use App\Http\Requests\Investigator\ProfileRequest;
use App\Http\Requests\Investigator\PasswordRequest;
use App\Models\Language;
use App\Models\Timezone;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use App\Models\InvestigatorLanguage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class InvestigatorController extends Controller
{
    public function index()
    {
        return view('investigator.index');
    }

    public function viewProfile()
    {
        $states          = State::all();
        $languageOptions = Language::all();
        $timezones       = Timezone::where('active', 1)->get();

        $user = auth()->user();
        $user->load([
            'investigatorServiceLines',
            'investigatorLicenses',
            'investigatorWorkVehicles',
            'investigatorLanguages.investigatorLanguage',
            'investigatorReview',
            'investigatorEquipment',
            'investigatorDocument',
            'investigatorAvailability'
        ]);

        $serviceLines    = $user->investigatorServiceLines;
        $survServiceLine = $user->investigatorServiceLines()->where('investigation_type', 'surveillance')->first();
        $statServiceLine = $user->investigatorServiceLines()->where('investigation_type', 'statements')->first();
        $miscServiceLine = $user->investigatorServiceLines()->where('investigation_type', 'misc')->first();
        $licenses        = $user->investigatorLicenses;
        $workVehicles    = $user->investigatorWorkVehicles;
        $languages       = $user->investigatorLanguages;
        $review          = $user->investigatorReview;
        $equipment       = $user->investigatorEquipment;
        $document        = $user->investigatorDocument;
        $availability    = $user->investigatorAvailability;

        return view('investigator.profile', compact(
            'states',
            'user',
            'serviceLines',
            'survServiceLine',
            'statServiceLine',
            'miscServiceLine',
            'licenses',
            'workVehicles',
            'languages',
            'review',
            'equipment',
            'document',
            'availability',
            'languageOptions',
            'timezones'
        ));
    }

    public function store(InvestigatorProfileRequest $request)
    {
        try {
            $user_id = Auth::user()->id;
            //  echo "<pre>"; print_r($request->all()); die;

            $user = User::find($user_id);
            $user->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'email'      => $request->email,
                'phone'      => $request->phone,
                'address'    => $request->address,
                'address_1'  => $request->address_1,
                'city'       => $request->city,
                'state'      => $request->state,
                'country'    => $request->country,
                'zipcode'    => $request->zipcode,
                'lat'        => $request->lat,
                'lng'        => $request->lng,
                'bio'        => $request->bio,
            ]);


            // check at least one service line is selected
            if (!$this->checkServiceLineIsChecked($request)) {
                return throw ValidationException::withMessages(
                    ['investigation_type' => 'Please select at least one service line.']
                );
            }

            // loop through licenses and check insurance is checked or not, if check then check file is uploaded or not, if not then throw multiple validation error for specific index of license
            $licenseValidationErrors = [];
            foreach ($request->licenses as $licenseKey => $license) {
                if ((array_key_exists("is_insurance", $license) && $license["is_insurance"]) && (!array_key_exists("insurance_previous", $license) || !$license["insurance_previous"])) {
                    if (!isset($license["insurance_file"])) {
                        $licenseValidationErrors["licenses.$licenseKey.insurance_file"] = 'Insurance file is required.';
                    } else {
                        // check file is jpeg, jpg, png
                        $fileExtension = $license["insurance_file"]->getClientOriginalExtension();
                        if (!in_array($fileExtension, ['jpeg', 'jpg', 'png'])) {
                            $licenseValidationErrors["licenses.$licenseKey.insurance_file"] = 'Insurance file must be jpeg, jpg, png.';
                        }
                    }
                }

                if ((array_key_exists("is_bonded", $license) && $license["is_bonded"]) && (!array_key_exists("bonded_previous", $license) || !$license["bonded_previous"])) {
                    if (!isset($license["bonded_file"])) {
                        $licenseValidationErrors["licenses.$licenseKey.bonded_file"] = 'Bonded file is required.';
                    } else {
                        // check file is jpeg, jpg, png
                        $fileExtension = $license["bonded_file"]->getClientOriginalExtension();
                        if (!in_array($fileExtension, ['jpeg', 'jpg', 'png'])) {
                            $licenseValidationErrors["licenses.$licenseKey.bonded_file"] = 'Bonded file must be jpeg, jpg, png.';
                        }
                    }
                }
            }

            if (count($licenseValidationErrors)) {
                return throw ValidationException::withMessages($licenseValidationErrors);
            }

            // Save service lines data
            if (count($request->investigation_type)) {
                $user->investigatorServiceLines()->delete();
                foreach ($request->investigation_type as $investigation_type) {
                    if (!isset($investigation_type["type"]))
                        continue;

                    $user->investigatorServiceLines()->create([
                        'investigation_type' => $investigation_type["type"],
                        'case_experience'    => $investigation_type["case_experience"],
                        'years_experience'   => $investigation_type["years_experience"],
                        'hourly_rate'        => $investigation_type["hourly_rate"],
                        'travel_rate'        => $investigation_type["travel_rate"],
                        'milage_rate'        => $investigation_type["milage_rate"],
                    ]);
                }
            }

            // Save review data
            if ($request->video_claimant_percentage) {
                $this->addReviewData($user, $request);
            }

            // Save equipment data
            if ($request->camera_type && $request->camera_model_number) {
                $this->addEquipment($user, $request);
            }


            // Save Licenses data
            if (count($request->licenses)) {
                $previousLinceseData = $user->investigatorLicenses->count() ? $user->investigatorLicenses->toArray() : [];

                $user->investigatorLicenses()->delete();
                foreach ($request->licenses as $licenseKey => $license) {
                    if (!isset($license["state"]) || !isset($license["license_number"]) || !isset($license["expiration_date"]))
                        continue;

                    $this->addLicense($user, $license, $licenseKey, $request, $previousLinceseData);
                }
            }

            // Save work vehicles data
            if (count($request->work_vehicles)) {

                $previousWorkVehiclesData = $user->investigatorWorkVehicles->count() ? $user->investigatorWorkVehicles->toArray() : [];

                $user->investigatorWorkVehicles()->delete();

                foreach ($request->work_vehicles as $workVehicleKey => $work_vehicle) {
                    if (!isset($work_vehicle["make"]) || !isset($work_vehicle["model"]) || !isset($work_vehicle["year"]))
                        continue;

                    $this->addWorkVehicle($user, $work_vehicle, $workVehicleKey, $request, $previousWorkVehiclesData);
                }
            }

            // Save languages data
            if (count($request->get('languages'))) {
                $user->investigatorLanguages()->delete();

                foreach ($request->get('languages') as $language) {
                    if (!isset($language["language"]))
                        continue;

                    $user->investigatorLanguages()->create([
                        'language'        => $language["language"],
                        'fluency'         => $language["fluency"],
                        'writing_fluency' => $language["writing_fluency"],
                    ]);
                }
            }

            // Save documents data
            $this->saveDocument($user, $request);

            // Save availability data
            $this->saveAvailability($user, $request);

            $user->update(['is_investigator_profile_submitted' => true]);


            session()->flash('success', 'Profile has been saved successfully.');

            return redirect('investigator/investigator-profile');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong, please try again later!');
            return redirect()->back();
        }

    }

    /**
     * Add review data
     * @param User $user
     * @param Request $request
     * @return void
     */
    private function addReviewData(User $user, Request $request)
    {
        $data = [
            'video_claimant_percentage' => $request->video_claimant_percentage,
        ];

        if ($request->hasFile('survelance_report')) {
            $data['survelance_report'] = $this->imageUploadHandler(
                $request->file('survelance_report'),
                'survelance-reports',
                $user->investigatorReview->survelance_report ?? null
            );
        }

        $user->investigatorReview()->updateOrCreate([
            'user_id' => $user->id
        ], $data);
    }

    /**
     * Add equipment data
     * @param User $user
     * @param Request $request
     * @return void
     */
    private function addEquipment(User $user, Request $request)
    {
        $user->investigatorEquipment()->updateOrCreate([
            'user_id' => $user->id
        ], [
            'camera_type'      => $request->camera_type,
            'camera_model'     => $request->camera_model_number,
            'is_dash_cam'      => $request->has('dashcam'),
            'is_convert_video' => $request->has('convert_video'),
        ]);
    }

    /**
     * Add license data
     * @param User $user
     * @param $data
     * @return void
     */
    private function addLicense(User $user, $data, $key, Request $request, $previousData)
    {
        if (isset($previousData[$key]['insurance_file']) && !isset($data['insurance_file'])) {
            $data['insurance_file'] = $previousData[$key]['insurance_file'];
        }

        if (isset($previousData[$key]['bonded_file']) && !isset($data['bonded_file'])) {
            $data['bonded_file'] = $previousData[$key]['bonded_file'];
        }

        $newData = [
            'state'           => $data['state'],
            'license_number'  => $data['license_number'],
            'expiration_date' => $data['expiration_date'],
            'is_insurance'    => array_key_exists('is_insurance', $data),
            'is_bonded'       => array_key_exists('is_bonded', $data),
        ];

        if (array_key_exists('is_insurance', $data) && isset($data['insurance_file'])) {
            // check if data is string or file
            if (is_string($data['insurance_file'])) {
                $newData['insurance_file'] = $data['insurance_file'];
            } else {
                $newData['insurance_file'] = $this->imageUploadHandler(
                    $request->file('licenses')[$key]['insurance_file'],
                    'insurance-files'
                );
            }
        } else {
            $newData['insurance_file'] = null;
        }

        if (array_key_exists('is_bonded', $data) && isset($data['bonded_file'])) {
            // check if data is string or file
            if (is_string($data['bonded_file'])) {
                $newData['bonded_file'] = $data['bonded_file'];
            } else {
                $newData['bonded_file'] = $this->imageUploadHandler(
                    $request->file('licenses')[$key]['bonded_file'],
                    'bonded-files'
                );
            }
        } else {
            $newData['bonded_file'] = null;
        }

        $user->investigatorLicenses()->create($newData);
    }

    /**
     * Add work vehicle data
     * @param User $user
     * @param $data
     * @param $key
     * @param Request $request
     * @return void
     */
    private function addWorkVehicle(User $user, $data, $key, Request $request, $previousData)
    {
        if (isset($previousData[$key]['picture']) && !isset($data['picture'])) {
            $data['picture'] = $previousData[$key]['picture'];
        }

        if (isset($previousData[$key]['proof_of_insurance']) && !isset($data['proof_of_insurance'])) {
            $data['proof_of_insurance'] = $previousData[$key]['proof_of_insurance'];
        }

        $newData = [
            'year'              => $data['year'],
            'make'              => $data['make'],
            'model'             => $data['model'],
            'insurance_company' => $data['insurance_company'],
            'policy_number'     => $data['policy_number'],
            'expiration_date'   => $data['expiration_date']
        ];

        if (array_key_exists('picture', $data)) {
            // check if data is string or file
            if (is_string($data['picture'])) {
                $newData['picture'] = $data['picture'];
            } else {
                $newData['picture'] = $this->imageUploadHandler(
                    $request->file('work_vehicles')[$key]['picture'],
                    'work-vehicles'
                );
            }
        }

        if (array_key_exists('proof_of_insurance', $data)) {
            // check if data is string or file
            if (is_string($data['proof_of_insurance'])) {
                $newData['proof_of_insurance'] = $data['proof_of_insurance'];
            } else {
                $newData['proof_of_insurance'] = $this->imageUploadHandler(
                    $request->file('work_vehicles')[$key]['proof_of_insurance'],
                    'proof-of-insurances'
                );
            }
        }

        $user->investigatorWorkVehicles()->create($newData);
    }

    /**
     * Save document data
     * @param User $user
     * @param Request $request
     * @return void
     */
    private function saveDocument(User $user, Request $request)
    {
//        dd($request->all());
        if ($request->hasFile('document_dl')) {
            $user->investigatorDocument()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'driving_license' => $this->imageUploadHandler(
                    $request->file('document_dl'),
                    'documents/dl',
                    $user->investigatorDocument->driving_license ?? null
                ),
            ]);
        }

        if ($request->hasFile('document_id')) {
            $user->investigatorDocument()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'passport' => $this->imageUploadHandler(
                    $request->file('document_id'),
                    'documents/ids',
                    $user->investigatorDocument->passport ?? null
                ),
            ]);
        }

        if ($request->hasFile('document_ssn')) {
            $user->investigatorDocument()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'ssn' => $this->imageUploadHandler(
                    $request->file('document_ssn'),
                    'documents/ssn',
                    $user->investigatorDocument->ssn ?? null
                ),
            ]);
        }

        if ($request->hasFile('document_birth_certificate')) {
            $user->investigatorDocument()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'birth_certificate' => $this->imageUploadHandler(
                    $request->file('document_birth_certificate'),
                    'documents/birth-certificates',
                    $user->investigatorDocument->birth_certificate ?? null
                ),
            ]);
        }

        if ($request->hasFile('document_form_19')) {
            $user->investigatorDocument()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'form_19' => $this->imageUploadHandler(
                    $request->file('document_form_19'),
                    'documents/form-19',
                    $user->investigatorDocument->form_19 ?? null
                ),
            ]);
        }
    }


    /**
     * Save availability data
     * @param User $user
     * @param Request $request
     * @return void
     */
    private function saveAvailability(User $user, Request $request)
    {
        if ($request->availability_days) {
            $user->investigatorAvailability()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'days' => $request->availability_days,
            ]);
        }

        if ($request->availability_hours) {
            $user->investigatorAvailability()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'hours' => $request->availability_hours,
            ]);
        }

        if ($request->availability_distance) {
            $user->investigatorAvailability()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'distance' => $request->availability_distance,
            ]);
        }

        if ($request->timezone) {
            $user->investigatorAvailability()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'timezone_id' => $request->timezone,
            ]);
        }
    }

    /**
     * Check service line is checked
     * @param Request $request
     * @return bool
     */
    private function checkServiceLineIsChecked(Request $request)
    {
        $isCheck = false;
        foreach ($request->investigation_type as $investigation_type) {
            if (isset($investigation_type["type"])) {
                $isCheck = true;
                break;
            }
        }

        return $isCheck;
    }


    /**
     * Image upload handler
     * @param $image
     * @param $request_path
     * @param $old_image
     * @return mixed
     */
    public function imageUploadHandler($image, $request_path = 'default', $old_image = null)
    {
        if (!is_null($old_image)) {
            if (Storage::disk('public')->exists($old_image)) {
                Storage::disk('public')->delete($old_image);
            }
        }

        return $image->store($request_path, 'public');
    }

    public function profileView()
    {
        $user = auth()->user();

        if (!$user->is_investigator_profile_submitted) {
            session()->flash('error', 'Please complete your profile first!');
            return redirect('/investigator/profile');
        }

        $states = State::all();

        $user->load([
            'investigatorServiceLines',
            'investigatorLicenses',
            'investigatorWorkVehicles',
            'investigatorLanguages.investigatorLanguage',
            'investigatorReview',
            'investigatorEquipment',
            'investigatorDocument',
            'investigatorAvailability',
            'investigatorLicenses.state_data',
            'investigatorAvailability.timezone'
        ]);

        $serviceLines = $user->investigatorServiceLines;
        $licenses     = $user->investigatorLicenses;
        $workVehicles = $user->investigatorWorkVehicles;
        $languages    = $user->investigatorLanguages;
        $review       = $user->investigatorReview;
        $equipment    = $user->investigatorEquipment;
        $document     = $user->investigatorDocument;
        $availability = $user->investigatorAvailability;

        return view('investigator.view-profile', compact(
            'states',
            'user',
            'serviceLines',
            'licenses',
            'workVehicles',
            'languages',
            'review',
            'equipment',
            'document',
            'availability'
        ));
    }

    public function myProfile()
    {  //show my profile page for investigator
        $profile = Auth::user();
        return view('investigator.my-profile', compact('profile'));
    }

    public function investigatorProfileUpdate(ProfileRequest $request)
    { //update profile for investigator
        $user_id = Auth::user()->id;
        $user    = User::find($user_id);
        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ]);
        session()->flash('success', 'Hi Investigator , Your Account Info Updated Sucessfully!');
        return redirect()->route('investigator.my-profile');
    }

    public function investigatorResetPassword()
    { //show reset password form for investigator
        return view('investigator.reset-password');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    /* protected function validator(array $data)
    {
        return Validator::make($data, [
            'password'   => ['required', 'string', 'min:10', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/'],
        ], [
            'password.regex' => 'Password is invalid, please follow the instructions below!',
        ]);
    } */

    public function investigatorPasswordUpdate(PasswordRequest $request)
    { //update password for investigator

        // dd('here');
        $user_id = Auth::user()->id;
        $user    = User::find($user_id);
        $user->update([
            'npassword' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Hi Investigator , Your Account Password Changed Sucessfully!');
        return redirect()->route('investigator.my-profile');
    }

}
