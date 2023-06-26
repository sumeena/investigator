<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Timezone;
use Illuminate\Http\Request;
use App\Http\Requests\CompanyAdmin\ProfileRequest;
use App\Http\Requests\CompanyAdmin\CompanyAdminProfileRequest;
use App\Http\Requests\CompanyAdmin\PasswordRequest;
use App\Models\InvestigatorLanguage;
use App\Models\State;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


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
        ]);
        $profile = $user->CompanyAdminProfile;
        $timezones = Timezone::where('active', 1)->get();

        return view('company-admin.profile', compact('profile', 'timezones'));
    }


    public function store(CompanyAdminProfileRequest $request)
    {
        //echo "<pre>"; print_r($request->all()); die;
        try {
            $user = Auth::user();
            $user->CompanyAdminProfile()->updateOrCreate([
                'user_id' => $user->id
            ], [
                'company_name' => $request->company_name,
                'company_phone' => $request->company_phone,
                'address' => $request->address,
                'address_1' => $request->address_1,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'zipcode' => $request->zipcode,
                'timezone_id' => $request->timezone,
            ]);

            $user->CompanyAdminProfile()->update(['is_company_profile_submitted' => true]);

            session()->flash('success', 'Company Profile Updated Sucessfully.');
            return redirect()->route('company-admin.view');
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong, please try again later!');
            return redirect()->back();
        }
    }

    public function findInvestigator(Request $request)
    {
        $states = State::all();
        $languageOptions = Language::all();
        $filtered = false;
        $investigators = [];

        if ($this->checkQueryAvailablity($request)) {
            $filtered = true;
            $investigators = User::investigatorFiltered($request)
                ->paginate(10);

        }

        if ($request->ajax()) {
            $html = view('company-admin.find-investigator-response', compact('investigators'))->render();

            return response()->json([
                'data' => $html,
            ]);
        }


        return view('company-admin.find-investigator',
            compact(
                'states',
                'languageOptions',
                'filtered',
                'investigators',
                'request'
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
        $user = User::find($user_id);
        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
        session()->flash('success', 'Hi, Your Account Info Updated Sucessfully!');
        return redirect()->route('company-admin.my-profile');
    }

    public function companyResetPassword()
    { //show reset password form for company
        return view('company-admin.reset-password');
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


    public function companyPasswordUpdate(PasswordRequest $request)
    { //update password for company
        $user_id = Auth::user()->id;
        $user = User::find($user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Hi, Your Account Password Changed Sucessfully!');
        return redirect()->route('company-admin.my-profile');
    }

    public function companyProfile()
    {
        $user = auth()->user();

        if (!$user->CompanyAdminProfile->is_company_profile_submitted) {
            session()->flash('error', 'Please complete your profile first!');
            return redirect()->route('company-admin.profile');
        }

        $user->load([
            'CompanyAdminProfile'
        ]);

        $CompanyAdminProfile = $user->CompanyAdminProfile;

        return view('company-admin.company-profile', compact(
            'CompanyAdminProfile'
        ));
    }

}
