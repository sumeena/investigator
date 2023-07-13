<?php

namespace App\Http\Controllers\Hm;

use App\Http\Controllers\Controller;
use App\Http\Requests\Hm\PasswordRequest;
use App\Http\Requests\Hm\ProfileRequest;
use App\Models\InvestigatorLanguage;
use App\Models\Language;
use App\Models\State;
use App\Models\User;
use App\Models\CompanyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class HmController extends Controller
{
    public function index()
    {
        return view('hm.index');
    }

    public function myProfile()
    {  //show my profile page for company
        $profile = auth()->user();
        return view('hm.my-profile', compact('profile'));
    }

    public function hmProfileUpdate(ProfileRequest $request)
    {
        $user = auth()->user();

        $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        session()->flash('success', 'Hi, Your Account Info Updated Successfully!');

        return redirect()->route('hm.my-profile');
    }

    public function hmResetPassword()
    { //show reset password form for company
        return view('hm.reset-password');
    }

    public function hmPasswordUpdate(PasswordRequest $request)
    {
        $user = auth()->user();

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        session()->flash('success', 'Hi, Your Account Password Changed Successfully!');

        return redirect()->route('hm.my-profile');
    }

    public function companyProfile()
    {
        $user = auth()->user();


        if (
            (!$user->companyAdmin
                || !$user->companyAdmin->company
                || !$user->companyAdmin->company->CompanyAdminProfile)
            &&
            (!$user?->companyAdmin?->company?->companyAdmin
                || !$user?->companyAdmin?->company?->companyAdmin?->company
                || !$user?->companyAdmin?->company?->companyAdmin?->company?->CompanyAdminProfile
                || !$user?->companyAdmin?->company?->companyAdmin?->company?->CompanyAdminProfile?->is_company_profile_submitted)
        ) {
            session()->flash('error', 'Please tell your company admin to complete company profile first!');
            return redirect()->route('hm.index');
        }


        $user->load([
            'companyAdmin',
            'companyAdmin.company',
            'companyAdmin.company.CompanyAdminProfile',
        ]);

        $CompanyAdminProfile = $user->companyAdmin->company->CompanyAdminProfile;
        $parentProfile = $user->companyAdmin?->company?->companyAdmin?->company?->CompanyAdminProfile;
        $companyAdmin = $user->companyAdmin?->company;

        return view('hm.company-profile', compact(
            'CompanyAdminProfile',
            'parentProfile',
            'companyAdmin'
        ));
    }

    public function companyUsers()
    {
        $user = auth()->user();

        $user->load([
            'companyAdmin',
            'companyAdmin.company',
            'companyAdmin.company.CompanyAdminProfile',
        ]);

        if (
            !$user->companyAdmin
            || !$user->companyAdmin->company
            || !$user->companyAdmin->company->CompanyAdminProfile
        ) {
            session()->flash('error', 'Please tell your company admin to complete company profile first!');
            return redirect()->route('hm.index');
        }

        $companyUsers = User::whereHas('companyAdmin', function ($q) {
            $q->where('parent_id', auth()->user()->companyAdmin->parent_id);
        })->whereHas('userRole', function ($q) {
            $q->where('role', ['company-admin', 'hiring-manager']);
        })->latest()->paginate(20);
        return view('hm.company-users', compact(
            'companyUsers'
        ));
    }

}
