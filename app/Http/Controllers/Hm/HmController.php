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
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
        ]);

        session()->flash('success', 'Hi, Your Account Info Updated Sucessfully!');

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
            !$user->hmCompanyAdmin
            || !$user->hmCompanyAdmin->companyAdmin
            || !$user->hmCompanyAdmin->companyAdmin->CompanyAdminProfile
        ) {
            session()->flash('error', 'Please tell your company admin to complete company profile first!');
            return redirect()->route('hm.index');
        }

        $user->load([
            'hmCompanyAdmin',
            'hmCompanyAdmin.companyAdmin',
            'hmCompanyAdmin.companyAdmin.CompanyAdminProfile',
        ]);

        $CompanyAdminProfile = $user->hmCompanyAdmin->companyAdmin->CompanyAdminProfile;

        return view('hm.company-profile', compact(
            'CompanyAdminProfile'
        ));
    }

    public function companyUsers()
    {
      $user               = Auth::user()->id;
      $currentUserData    = CompanyUser::where('user_id',$user)->first();
      $companyUsers       = '';
      if ($currentUserData) {
            $companies    = CompanyUser::where('parent_id', $currentUserData->parent_id)->pluck('user_id');
            $companyUsers = User::whereIn('id', $companies)->paginate(10);
        }
        return view('hm.company-users', compact(
            'companyUsers'
        ));
   }

}
