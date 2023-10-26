<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Mail\JobUpdate;
use App\Models\Assignment;
use App\Models\InvestigatorSearchHistory;
use App\Models\Language;
use App\Models\Timezone;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyAdmin\ProfileRequest;
use App\Http\Requests\CompanyAdmin\CompanyAdminProfileRequest;
use App\Http\Requests\CompanyAdmin\PasswordRequest;
use App\Models\AssignmentUser;
use App\Models\InvestigatorLanguage;
use App\Models\State;
use App\Models\User;
use App\Models\CompanyAdminProfile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;


class CompanyAdminController extends Controller
{
    public function index()
    {
        return view('company-admin.index');
    }

    public function viewProfile()
    {

        $user = auth()->user();
        $user->load([
            'CompanyAdminProfile',
            'parentCompany.company.CompanyAdminProfile'
        ]);

        $profile       = $user->CompanyAdminProfile;
        $parentCompany = CompanyAdminProfile::find($user->company_profile_id);
        $timezones     = Timezone::where('active', 1)->get();
        return view('company-admin.profile', compact('profile', 'timezones', 'user', 'parentCompany'));
    }


    public function store(CompanyAdminProfileRequest $request)
    {

        if($request->make_assignments_private == NULL)
            $request->make_assignments_private = 0;

        try {
            $loginUser = Auth::user();
            $loginUseId =$loginUser->id;
            if(isset($request->companyProfileId) && !empty($request->companyProfileId)){

              $user_id = Auth::user()->id;
              $user    = CompanyAdminProfile::find($request->companyProfileId);
              $user->update([
                  'company_name'  => $request->company_name,
                  'company_phone' => $request->company_phone,
                  'address'       => $request->address,
                  'address_1'     => $request->address_1,
                  'city'          => $request->city,
                  'state'         => $request->state,
                  'country'       => $request->country,
                  'zipcode'       => $request->zipcode,
                  'timezone_id'   => $request->timezone,
                  'make_assignments_private' => $request->make_assignments_private
              ]);
            }else{
              $companyAdminProfile=$loginUser->CompanyAdminProfile()->updateOrCreate([
                  'user_id' => $loginUseId
              ], [
                  'company_name'  => $request->company_name,
                  'company_phone' => $request->company_phone,
                  'address'       => $request->address,
                  'address_1'     => $request->address_1,
                  'city'          => $request->city,
                  'state'         => $request->state,
                  'country'       => $request->country,
                  'zipcode'       => $request->zipcode,
                  'timezone_id'   => $request->timezone,
                  'make_assignments_private' => $request->make_assignments_private
              ]);

              $loginUser->CompanyAdminProfile()->update(['is_company_profile_submitted' => true]);
              $user    = User::find($loginUseId);
              $user->update([
                  'company_profile_id' => $companyAdminProfile->id
              ]);
            }


            session()->flash('success', 'Company Profile Updated Sucessfully.');
            return redirect()->route('company-admin.view');
        } catch (\Exception $e) {
            echo "Error: " . $e->getMessage();
            session()->flash('error', 'Something went wrong, please try again later!'.$e->getMessage());
            return redirect()->back();
        }
    }

    public function findInvestigator(Request $request)
    {
        $states          = State::all();
        $languageOptions = Language::all();
        $filtered        = false;
        $investigators   = [];
        $assignments     = Assignment::where('user_id', auth()->id())->paginate(10);
        $assignmentCount = Assignment::where('user_id', auth()->id())->count();
        $assignmentID = Assignment::where('id', $request->assignment_id)->pluck('assignment_id');
        $assignmentUsers = AssignmentUser::where('assignment_id',$request->assignment_id )->pluck('user_id')->toArray();
        if ($this->checkQueryAvailablity($request)) {
            $filtered      = true;
            $investigators = User::investigatorFiltered($request)
                ->paginate(20);
        }

        if ($request->ajax()) {

            $html = view('company-admin.find-investigator-response', compact('investigators', 'assignmentCount','assignmentUsers'))->render();
            $login=route('login');
            if(isset($request->assignment_id) && (isset($request->fieldsUpdated) && $request->fieldsUpdated == '1')){

                $notificationData = [
                'title'        => 'The assignment ID '.$assignmentID[0].' which you were invited for has been updated.',
                'loginUrl'        => $login,
                'login'        => ' to your account so view the details.',
                'thanks'        => 'Ilogistics Team',
                ];
                $assignmentUsers = AssignmentUser::where(['assignment_id' => $request->assignment_id,'hired' => 1])->get();
                if(count($assignmentUsers) == 0){
                $assignmentUsers = AssignmentUser::where(['assignment_id' => $request->assignment_id,'hired' => 0])->get();
                    foreach ($assignmentUsers as $item) {
                        $investigatorUser = User::find($item->user_id);

                        Mail::to($investigatorUser->email)->send(new JobUpdate($notificationData));
                    }
                }
            }
            return response()->json([
                'data' => $html,
            ]);
        }

        return view(
            'company-admin.find-investigator',
            compact(
                'states',
                'languageOptions',
                'filtered',
                'investigators',
                'request',
                'assignments'
            )
        );
    }


    /**
     * @param Request $request
     * @return bool
     */
    private function checkQueryAvailablity(Request $request): bool
    {
        return $request->get('address')
            || $request->get('city')
            || $request->get('state')
            || $request->get('zipcode')
            || $request->get('license')
            || $request->get('languages')
            || $request->get('surveillance')
            || $request->get('statements')
            || $request->get('distance')
            || $request->get('misc');
    }

    public function myProfile()
    {  //show my profile page for company
        $profile = Auth::user();
        return view('company-admin.my-profile', compact('profile'));
    }

    public function companyProfileUpdate(ProfileRequest $request)
    { //update profile for company
        $user_id = Auth::user()->id;
        $user    = User::find($user_id);
        $user->update([
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ]);
        session()->flash('success', 'Hi, Your Account Info Updated Successfully!');
        return redirect()->route('company-admin.my-profile');
    }

    public function companyResetPassword()
    {
      /** show reset password form for company **/
        return view('company-admin.reset-password');
    }


    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */



    public function companyPasswordUpdate(PasswordRequest $request)
    { //update password for company
        $user_id = Auth::user()->id;
        $user    = User::find($user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Hi, Your Account Password Changed Sucessfully!');
        return redirect()->route('company-admin.my-profile');
    }

    public function companyProfile()
    {
        $user = auth()->user();
        if (isset($user->company_profile_id) && $user->company_profile_id !== null) {

        }else {
          session()->flash('error', 'Please complete your profile first!');
          return redirect()->route('company-admin.profile');
        }
        $user->load([
            'CompanyAdminProfile',
            'companyAdmin',
            'companyAdmin.company',
            'companyAdmin.company.CompanyAdminProfile'
        ]);

        $CompanyAdminProfile = $user->CompanyAdminProfile;
        $parentProfile       = CompanyAdminProfile::find($user->company_profile_id);

        return view('company-admin.company-profile', compact(
            'CompanyAdminProfile',
            'parentProfile',
            'user'
        ));
    }


    public function saveInvestigatorSearchHistory(Request $request)
    {

        $availability = $request->availability.','.$request->start_time.' - '.$request->end_time;
        InvestigatorSearchHistory::updateOrCreate([
            'user_id'      => auth()->id(),
            'assignment_id'=> $request->assignment_id],[
            'street'       => $request->street,
            'city'         => $request->city,
            'state'        => $request->state,
            'zipcode'      => $request->zipcode,
            'country'      => $request->country,
            'lat'          => $request->lat,
            'lng'          => $request->lng,
            'surveillance' => $request->surveillance,
            'statements'   => $request->statements,
            'misc'         => $request->misc,
            'license_id'   => $request->license,
            'distance'     => $request->distance,
            'withInternalInvestigator'     => $request->withInternalInvestigator,
            'withExternalInvestigator'     => $request->withExternalInvestigator,
            'languages'    => $request->get('languages'),
            'availability' => $availability
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Investigator search history saved successfully!',
        ]);
    }


    public function updateInvestigatorSearchHistory(Request $request)
    {
        $availability = $request->availability.','.$request->start_time.' - '.$request->end_time;
        InvestigatorSearchHistory::where('id',$request->search_history_id)->update([
            'user_id'      => auth()->id(),
            'street'       => $request->street,
            'city'         => $request->city,
            'state'        => $request->state,
            'zipcode'      => $request->zipcode,
            'country'      => $request->country,
            'lat'          => $request->lat,
            'lng'          => $request->lng,
            'surveillance' => $request->surveillance,
            'statements'   => $request->statements,
            'misc'         => $request->misc,
            'license_id'   => $request->license,
            'distance'     => $request->distance,
            'withInternalInvestigator'     => $request->withInternalInvestigator,
            'withExternalInvestigator'     => $request->withExternalInvestigator,
            'languages'    => $request->get('languages'),
            'availability' => $availability,
            'assignment_id'=> $request->assignment_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Investigator search history saved successfully!',
        ]);
    }
}
