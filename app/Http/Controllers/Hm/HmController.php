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
use App\Models\CompanyAdminProfile;
use Auth;
use App\Models\Assignment;

class HmController extends Controller
{
    public function index()
    {
      $user = auth()->user();
      $companyUser = CompanyUser::where('user_id', auth()->id())->exists();
      $internalCount = User::where('investigatorType', "internal")->where('company_profile_id', $user->company_profile_id)->count();
      $companyAdminCount = User::where('role', 3)->where('company_profile_id', $user->company_profile_id)->count();
      $companyHmCount = User::where('role', 4)->where('company_profile_id', $user->company_profile_id)->count();

      if($companyUser) {
          $parent = CompanyUser::where('user_id', auth()->id())->pluck('parent_id');
          $parentId = $parent[0];
      }
      $parentId = NULL;
      $assignmentCount = Assignment::withCount('users')
      ->where(['user_id' => $user->id, 'is_delete' => NULL])
      ->when($parentId != '', function ($query) use ($parentId) {
          $query->orWhere(['user_id' => $parentId, 'is_delete' => NULL]);
      })
      ->orderBy('created_at','desc')->count();

      return view('hm.index',compact('user','assignmentCount','internalCount','companyAdminCount','companyHmCount'));

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


        if (isset($user->company_profile_id) && $user->company_profile_id !== null) {

        }else {
            session()->flash('error', 'Please tell your company admin to complete company profile first!');
            return redirect()->route('hm.index');
        }


        $user->load([
            'companyAdmin',
            'companyAdmin.company',
            'companyAdmin.company.CompanyAdminProfile',
        ]);

        $CompanyAdminProfile = $user->companyAdmin->company->CompanyAdminProfile;
        $parentProfile = CompanyAdminProfile::find($user->company_profile_id);
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

        if (isset($user->company_profile_id) && $user->company_profile_id !== null) {

        }else {
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
