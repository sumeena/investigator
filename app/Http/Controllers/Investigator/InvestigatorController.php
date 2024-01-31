<?php

namespace App\Http\Controllers\Investigator;

use App\Http\Controllers\Controller;
use App\Http\Requests\Investigator\InvestigatorProfileRequest;
use App\Http\Requests\Investigator\ProfileRequest;
use App\Http\Requests\Investigator\PasswordRequest;
use App\Models\CalendarEvents;
use App\Models\GoogleAuthUsers;
use App\Models\Language;
use App\Models\Timezone;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\State;
use App\Models\InvestigatorLanguage;
use App\Models\NylasUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\InvestigatorServiceLine;
use App\Models\InvestigatorType;

class InvestigatorController extends Controller
{
    protected $base_url;

    function __construct()
    {
        $this->base_url = URL::to('/');
    }

    public function index()
    {
        $user = auth()->user();

        $invitationsCount = AssignmentUser::where('user_id', auth()->id())->with(['assignment', 'user', 'assignment.author.CompanyAdminProfile'])->orderBy('created_at', 'desc')->count();

        return view('investigator.index', compact('invitationsCount'));
    }

    public function viewProfile()
    {
        $states          = State::all();
        $languageOptions = Language::all();
        $timezones       = Timezone::where('active', 1)->get();
        $investigation_types = InvestigatorType::all();

        $user              = auth()->user();
        $userId            = $user->id;
        
        $googleAuthDetails = GoogleAuthUsers::where('user_id', $userId)->exists();
        $nylasUser = NylasUsers::where(['user_id' => $userId, 'provider' => 'gmail'])->exists();
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

        $serviceLines = $user->investigatorServiceLines()->with('investigationType')->get();

        $survServiceLine =  $statServiceLine = '';
        $miscServiceLine = array();
        foreach ($serviceLines as $serviceLine) {
            if ($serviceLine->investigationType['type_name'] == 'surveillance')
                $survServiceLine = $serviceLine;
            else if ($serviceLine->investigationType['type_name'] == 'statements')
                $statServiceLine = $serviceLine;
            else
                $miscServiceLine[] = $serviceLine;
            // if($serviceLine->investigationType['type_name'] == 'statements')
        }

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
            'timezones',
            'googleAuthDetails',
            'nylasUser'
        ));
    }

    public function store(InvestigatorProfileRequest $request)
    {
        try {
            $user_id = Auth::user()->id;
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
            // dd(count($request->investigation_type));
            // Save service lines data
            if (count($request->investigation_type)) {
                $user->investigatorServiceLines()->delete();
                foreach ($request->investigation_type as $investigation_type) {
                    if (!isset($investigation_type["type"]))
                        continue;

                    if (isset($investigation_type['misc_service_name'])) {
                        foreach ($investigation_type['misc_service_name'] as $key => $misc_service) {
                            if ($misc_service) {
                                $serviceLinesInvestigationTypes = InvestigatorType::firstOrCreate(
                                    ['type_name' => $misc_service]
                                );

                                $user->investigatorServiceLines()->updateOrCreate([
                                    'investigation_type_id' => $serviceLinesInvestigationTypes->id
                                ], [
                                    'case_experience'    => $investigation_type["case_experience"][$key],
                                    'years_experience'   => $investigation_type["years_experience"][$key],
                                    'hourly_rate'        => $investigation_type["hourly_rate"][$key],
                                    'travel_rate'        => $investigation_type["travel_rate"][$key],
                                    'milage_rate'        => $investigation_type["milage_rate"][$key],
                                ]);
                            }
                        }
                    }
                    if(isset($investigation_type['service_name'])) {
                    $serviceLinesInvestigationTypes = InvestigatorType::firstOrCreate(
                        ['type_name' => $investigation_type['service_name']]
                    );
                    $user->investigatorServiceLines()->updateOrCreate([
                        'investigation_type_id' => $serviceLinesInvestigationTypes->id
                    ], [
                        'case_experience'    => $investigation_type["case_experience"],
                        'years_experience'   => $investigation_type["years_experience"],
                        'hourly_rate'        => $investigation_type["hourly_rate"],
                        'travel_rate'        => $investigation_type["travel_rate"],
                        'milage_rate'        => $investigation_type["milage_rate"],
                    ]);
                }
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
            dd($e);
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

        $states            = State::all();
        $userId            = Auth::user()->id;
        $googleAuthDetails = GoogleAuthUsers::where('user_id', $userId)->exists();
        $nylasUser = NylasUsers::where(['user_id' => $userId, 'provider' => 'gmail'])->exists();
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

        // $serviceLines = $user->investigatorServiceLines;
        $serviceLines = $user->investigatorServiceLines()->with('investigationType')->get();
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
            'availability',
            'googleAuthDetails',
            'nylasUser'
        ));
    }

    public function myProfile()
    {  //show my profile page for investigator
        $profile           = Auth::user();
        $userId            = Auth::user()->id;
        $googleAuthDetails = GoogleAuthUsers::where('user_id', $userId)->exists();
        $nylasUser = NylasUsers::where(['user_id' => $userId, 'provider' => 'gmail'])->exists();
        return view('investigator.my-profile', compact('profile', 'googleAuthDetails', 'nylasUser'));
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

    public function investigatorPasswordUpdate(PasswordRequest $request)
    { //update password for investigator

        $user_id = Auth::user()->id;
        $user    = User::find($user_id);
        $user->update([
            'npassword' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Hi Investigator , Your Account Password Changed Sucessfully!');
        return redirect()->route('investigator.my-profile');
    }


    /** Sync Calendar */

    public function investigatorSyncCalendar(Request $request)
    {
        if (isset($request->google)) {
            $this->googleOauth2Callback();
        }
    }

    public function googleOauth2Callback()
    {
        $userId = Auth::user()->id;

        $userInfo = GoogleAuthUsers::where('user_id', $userId)->get();

        // Generate new Access Token and Refresh Token if token.json doesn't exist

        if (!GoogleAuthUsers::where('user_id', $userId)->exists()) {

            $redirectUri   = $this->base_url . '/investigator/sync-calendar/google-oauth2callback';
            $googleConfigs = [
                'response_type'          => 'code',
                'access_type'            => 'offline',
                'client_id'              => Config::get('constants.GOOGLE_CLIENT_ID'),
                'redirect_uri'           => $redirectUri,
                'scope'                  => implode(' ', Config::get('constants.GOOGLE_SCOPES')),
                'prompt'                 => 'consent',
                'include_granted_scopes' => 'true',
                'state'                  => 'state_parameter_passthrough_value',
            ];

            $authUrl = Config::get('constants.GOOGLE_OAUTH_AUTH_URL') . '?' . http_build_query($googleConfigs);

            if (!isset($_GET['code'])) {
                header('Location:' . $authUrl);
                exit;
            }

            if (isset($_GET['code'])) {
                $code = $_GET['code'];         // Visit $authUrl and get the authentication code
            } else {
                return;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, Config::get('constants.GOOGLE_OAUTH_ACCESS_TOKEN_URL'));
            curl_setopt($ch, CURLOPT_POST, TRUE);
            curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                'code'          => $code,
                'client_id'     => Config::get('constants.GOOGLE_CLIENT_ID'),
                'client_secret' => Config::get('constants.GOOGLE_CLIENT_SECRET'),
                'redirect_uri'  => $redirectUri,
                'grant_type'    => 'authorization_code',
            ]));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
            $responseArray = json_decode($response);

            GoogleAuthUsers::updateOrCreate(['user_id' => $userId], ['access_token' => $responseArray->access_token, 'expires_in' => date("Y-m-d H:i:s", strtotime("+$responseArray->expires_in seconds")), 'refresh_token' => $responseArray->refresh_token, 'scope' => $responseArray->scope, 'token_type' => $responseArray->token_type, 'id_token'      => $responseArray->id_token]);
        } else if (GoogleAuthUsers::where('user_id', $userId)->exists() && strtotime($userInfo[0]->expires_in) < strtotime(date('Y-m-d H:i:s'))) {
            $access_token  = $userInfo[0]->access_token;
            $refresh_token = $userInfo[0]->refresh_token;
            // Check if the access token already expired
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, Config::get('constants.GOOGLE_OAUTH_TOKEN_VALIDATION_URL') . '?access_token=' . $access_token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $error_response = curl_exec($ch);
            $array          = json_decode($error_response);
            if (isset($array->error)) {
                // Generate new Access Token using old Refresh Token
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, Config::get('constants.GOOGLE_NEW_ACCESS_TOKEN_URL'));
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                    'client_id'     => Config::get('constants.GOOGLE_CLIENT_ID'),
                    'client_secret' => Config::get('constants.GOOGLE_CLIENT_SECRET'),
                    'refresh_token' => $refresh_token,
                    'grant_type'    => 'refresh_token',
                ]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                $responseArray = json_decode($response);
                GoogleAuthUsers::updateOrCreate(['user_id' => $userId], ['access_token' => $responseArray->access_token, 'expires_in'   => date("Y-m-d H:i:s", strtotime("+$responseArray->expires_in seconds")), 'id_token'     => $responseArray->id_token]);
            }
        }
        header('Location: ' . $this->base_url . '/investigator/calendar');
        exit;
    }

    public function investigatorCalendar()
    {
        $this->checkTokenExpiry();
        $userId            = Auth::user()->id;
        $userName          = Auth::user()->first_name;
        $userEmail         = Auth::user()->email;
                
        $googleAuthDetails = GoogleAuthUsers::where('user_id', $userId)->exists();

        $nylasUser = NylasUsers::where(['user_id' => $userId, 'provider' => 'gmail'])->exists();

        $calendarEvents = CalendarEvents::where('user_id', $userId)->exists();

        $profile = array();

        if ($googleAuthDetails && (!$nylasUser || !$calendarEvents)) {

            $userInfo = GoogleAuthUsers::where('user_id', $userId)->get();

            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL, 'https://www.googleapis.com/oauth2/v2/userinfo?access_token=' . $userInfo[0]->access_token);


            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");

            $result = curl_exec($ch);
            curl_close($ch);

            $userProfile = json_decode($result);

            $google_settings = [
                'google_client_id'     => Config::get('constants.GOOGLE_CLIENT_ID'),
                'google_client_secret' => Config::get('constants.GOOGLE_CLIENT_SECRET'),
                'google_refresh_token' => $userInfo[0]->refresh_token,
            ];

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL            => Config::get('constants.NYLAS_API_URL') . 'connect/authorize',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => '{
                "client_id": "' . Config::get('constants.NYLAS_CLIENT_ID') . '",
                "name": "' . $userName . '",
                "email_address": "' . $userProfile->email . '",
                "provider": "gmail",
                "settings": ' . json_encode($google_settings) . ',
                "scopes": "calendar"
            }',
                CURLOPT_HTTPHEADER     => array(
                    'Content-Type: application/json'
                ),
            ));

            $response = curl_exec($curl);
            $array    = json_decode($response);
            curl_close($curl);

            if($array) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL            => Config::get('constants.NYLAS_API_URL') . 'connect/token',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS     => '{
                "client_id": "' . Config::get('constants.NYLAS_CLIENT_ID') . '",
                "client_secret": "' . Config::get('constants.NYLAS_CLIENT_SECRET') . '",
                "code": "' . $array->code . '"
            }',
                CURLOPT_HTTPHEADER     => array(
                    'Content-Type: application/json'
                ),
            ));

            $nylasResponse = curl_exec($curl);
            curl_close($curl);
            $nylasResponseArray = json_decode($nylasResponse);
            NylasUsers::updateOrCreate([
                'user_id'  => $userId,
                'provider' => 'gmail'
            ], [
                'nylas_id'          => $nylasResponseArray->id,
                'access_token'      => $nylasResponseArray->access_token,
                'account_id'        => $nylasResponseArray->account_id,
                'billing_state'     => $nylasResponseArray->billing_state,
                'email_address'     => $nylasResponseArray->email_address,
                'linked_at'         => $nylasResponseArray->linked_at,
                'name'              => $nylasResponseArray->name,
                'object'            => $nylasResponseArray->object,
                'organization_unit' => $nylasResponseArray->organization_unit,
                'provider'          => $nylasResponseArray->provider,
                'sync_state'        => $nylasResponseArray->sync_state
            ]);

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL            => Config::get('constants.NYLAS_API_URL') . 'calendars',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'GET',
                CURLOPT_HTTPHEADER     => array(
                    'Content-Type: application/json',
                    'Authorization: Bearer ' . $nylasResponseArray->access_token
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            $responseArr['calendars'] = json_decode($response);
            $profile['calendars']     = $responseArr['calendars'];
        } }

        $profile['user'] = Auth::user();

        $userId = Auth::user()->id;

        return view('investigator.calendar', compact('profile', 'nylasUser', 'googleAuthDeatils', 'calendarEvents'));
    }

    /** Check google access token expiry */
    public function checkTokenExpiry()
    {
        $userId   = Auth::user()->id;
        $userInfo = GoogleAuthUsers::where('user_id', $userId)->get();

        if (GoogleAuthUsers::where('user_id', $userId)->exists() && strtotime($userInfo[0]->expires_in) < strtotime(date('Y-m-d H:i:s'))) {

            $access_token  = $userInfo[0]->access_token;
            $refresh_token = $userInfo[0]->refresh_token;
            // Check if the access token already expired
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, Config::get('constants.GOOGLE_OAUTH_TOKEN_VALIDATION_URL') . '?access_token=' . $access_token);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $error_response = curl_exec($ch);
            $array          = json_decode($error_response);

            if (isset($array->error)) {
                // Generate new Access Token using old Refresh Token
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, Config::get('constants.GOOGLE_NEW_ACCESS_TOKEN_URL'));
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/x-www-form-urlencoded']);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
                    'client_id'     => Config::get('constants.GOOGLE_CLIENT_ID'),
                    'client_secret' => Config::get('constants.GOOGLE_CLIENT_SECRET'),
                    'refresh_token' => $refresh_token,
                    'grant_type'    => 'refresh_token',
                ]));
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($ch);
                curl_close($ch);

                $responseArray = json_decode($response);
                $updateGoogleAccessToken = GoogleAuthUsers::updateOrCreate(['user_id' => $userId], [
                    'access_token' => $responseArray->access_token,
                    'expires_in'   => date("Y-m-d H:i:s", strtotime("+$responseArray->expires_in seconds")),
                    // 'id_token'     => $responseArray->id_token
                ]);
            }
        }
    }

    public function investigatorCalendarEvents(Request $request)
    {
        $userId   = Auth::user()->id;
        $userInfo = GoogleAuthUsers::where('user_id', $userId)->get();

        $nylasUser  = NylasUsers::where(['user_id' => $userId, 'provider' => 'gmail'])->get();
        $calendarId = $request->calendar_id;
        $curl       = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => Config::get('constants.NYLAS_API_URL') . 'events?calendar_id=' . $calendarId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'GET',
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json',
                'Authorization: Bearer ' . $nylasUser[0]->access_token
            ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);

        $events = json_decode($response);

        if (isset($events->message)) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL            => Config::get('constants.NYLAS_API_URL') . 'oauth/revoke',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING       => '',
                CURLOPT_MAXREDIRS      => 10,
                CURLOPT_TIMEOUT        => 0,
                CURLOPT_USERPWD        => "cg7lkuuvftx7yffwmz3xorqdk:",
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST  => 'POST',
                CURLOPT_POSTFIELDS, http_build_query([
                    'user' => $nylasUser[0]->access_token
                ]),
                CURLOPT_HTTPHEADER     => array(
                    'Content-Type: application/json',
                    'Accept: application/json',
                    'Authorization: Bearer ' . $nylasUser[0]->access_token
                ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $nylasResponseArray = json_decode($response);
        }
        $calEventsArray = '';
        $calendarEvents = '[';
        foreach ($events as $event) {

            if (isset($event->when->start_time) && isset($event->when->end_time)) {
                $calendarEvents .= json_encode([
                    'title' => $event->title, 'start' => $event->when->start_time * 1000,
                    'end'   => $event->when->end_time * 1000
                ]) . ',';

                $calEventsArray = array(
                    'user_id'    => $userId, 'calendar_id' => $calendarId, 'event_id' => $event->id,
                    'title'      => $event->title,
                    'start_date' => date('Y-m-d', $event->when->start_time),
                    'end_date'   => date('Y-m-d', $event->when->end_time),
                    'start_time' => date('H:i:s', $event->when->start_time),
                    'end_time'   => date('H:i:s', $event->when->end_time)
                );
            } elseif (isset($event->when->start_date) && isset($event->when->end_date)) {
                $start_time = strtotime("" . $event->when->start_date . "") + 3600;
                $end_time = strtotime("" . $event->when->end_date . "") + 3600 * 23.9;
                $calendarEvents .= json_encode([
                    'title' => $event->title, 'start' => $start_time * 1000,
                    'end'   => $end_time * 1000
                ]) . ',';

                $calEventsArray = array(
                    'user_id'  => $userId, 'calendar_id' => $calendarId, 'event_id' => $event->id,
                    'title'    => $event->title, 'start_date' => $event->when->start_date,
                    'end_date' => $event->when->end_date,
                    'start_time' => date('H:i:s', $start_time),
                    'end_time'   => date('H:i:s', $end_time)
                );
            } else {
                $calendarEvents .= json_encode(['title' => $event->title, 'start' => $event->when->date]) . ',';
                $start_time = strtotime("" . $event->when->date . "") + 3600;
                $end_time = strtotime("" . $event->when->date . "") + 3600 * 23.9;
                $calEventsArray = array(
                    'user_id'  => $userId, 'calendar_id' => $calendarId, 'event_id' => $event->id,
                    'title'    => $event->title, 'start_date' => $event->when->date,
                    'end_date' => $event->when->date,
                    'start_time' => date('H:i:s', $start_time),
                    'end_time'   => date('H:i:s', $end_time)
                );
            }
            CalendarEvents::updateOrCreate(['event_id' => $event->id], $calEventsArray);
            $calEventsArray = '';
        }
        $calEvents = trim($calendarEvents, ',') . ']';

        return $calEvents;
    }

    public function disconnectCalendar(Request $request)
    {
        $userId    = Auth::user()->id;

        $nylasUser = NylasUsers::where(['user_id' => $userId, 'provider' => 'gmail'])->get();

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL            => Config::get('constants.NYLAS_API_URL') . 'a/' . Config::get('constants.NYLAS_CLIENT_ID') . '/accounts/' . $nylasUser[0]->account_id,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_USERPWD        => "cg7lkuuvftx7yffwmz3xorqdk:",
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'DELETE',
            CURLOPT_HTTPHEADER     => array(
                'Content-Type: application/json',
                'Accept: application/json',
                'CLIENT_SECRET: ' . Config::get('constants.NYLAS_CLIENT_SECRET')
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $nylasResponseArray = json_decode($response);


        if ($nylasResponseArray) {
            $user      = GoogleAuthUsers::where('user_id', $userId)->delete();
            $nylasUser = NylasUsers::where(['user_id' => $userId, 'provider' => 'gmail'])->delete();
            $calEvents = CalendarEvents::where('user_id', $userId)->delete();
        }
        return $user;
    }

    public function removeEvents(Request $request)
    {
        $userId = Auth::user()->id;
        $calEvents = CalendarEvents::where('user_id', $userId)->delete();
        return $calEvents;
    }

    public function investigatorCalendarEventsOnLoad(Request $request)
    {

        $userId = Auth::user()->id;
        $events = CalendarEvents::where('user_id', $userId)->get();

        if (count($events) > 0) {

            $content = new Request([
                'calendar_id' => $events[0]->calendar_id
            ]);
            $events = $this->investigatorCalendarEvents($content);

            return $events;
        }
    }
    public static function checkInvestigatorType()
    {
        if (auth()->user()->investigatorType != 'internal') {
            return "Contractor";
        }
    }

    public function searchForServiceLine(Request $request)
    {
        return InvestigatorType::where('type_name', 'LIKE', '%' . $request->q . '%')->get();
    }
}
