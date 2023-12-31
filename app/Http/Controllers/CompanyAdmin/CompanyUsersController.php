<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyAdmin\CompanyUserRequest;
use App\Mail\UserCredentialMail;
use App\Notifications\WelcomeMailNotification;
use App\Models\Role;
use App\Models\User;
use App\Models\CompanyUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\CompanyAdmin\CompanyAdminRequest;
use App\Http\Requests\Admin\CompanyAdmin\PasswordRequest;
use Illuminate\Support\Facades\Mail;
use App\Rules\CompanyAdminMatchDomain;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CompanyUsersController extends Controller
{
    public function index()
    {   //listing for all hm + company admin roles user
      
      $companyAdmins = User::whereHas('userRole', function ($q) {
             $q->whereIn('role', ['company-admin', 'hiring-manager']);
         })->whereHas('companyAdmin', function ($q) {
             $q->where('parent_id', auth()->id());
         })->with('CompanyAdminProfile', 'userRole')->paginate(20);

         return view('company-admin.company-users.index', compact('companyAdmins'));
    }

    public function view()
    { //return view for add new hr
        $roles = Role::where('role', 'company-admin')
            ->orWhere('role', 'hiring-manager')->get();
        $user = User::with('parentCompany.company')->find(auth()->user()->id);
        return view('company-admin.company-users.add', compact('roles', 'user'));
    }

    public function store(CompanyUserRequest $request)
    {

        $password = isset($request->password) ? $request->password : Str::random(10);
        $data     = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'website'      => $request->website,
            'company_profile_id'   => $request->companyProfileId,
            'password'   => Hash::make($password),
            'role'       => $request->role,

        ];
        $user     = User::updateOrCreate([
            'id' => $request->id
        ], $data);

        // Create company user data
        CompanyUser::updateOrCreate([
            'user_id'   => $user->id,
            'parent_id' => auth()->id()
        ]);
        if ($request->id) {
            session()->flash('success', 'Company User Record Updated Successfully!');
        } else {

            $user->notify(new WelcomeMailNotification($user,$password));
            session()->flash('success', 'Company User Record Added Successfully!');
        }

        return redirect()->route('company-admin.company-users.index');
    }

    public function edit($id)
    {
        //find exist hr user and return data in form
        $companyAdmin = User::find($id);
        $roles        = Role::where('role', 'company-admin')
            ->orWhere('role', 'hiring-manager')->get();
        $user = User::with('parentCompany.company')->find(auth()->user()->id);
        return view('company-admin.company-users.add', compact('companyAdmin', 'roles', 'user'));
    }

    public function delete($id)
    {  //delete hr user from table
        User::find($id)->delete();
        session()->flash('success', 'Company User Record Deleted Successfully!');
        return redirect()->route('company-admin.company-users.index');
    }

    public function resetPassword($id)
    { //show reset password form for company
        $user_id = isset($id) ? $id : '';
        return view('company-admin.company-users.reset-password', compact('user_id'));
    }
    public function update(Request $request)
    {
        //$password='devteeest67855@gmail.com';
      $data     = [
          'first_name' => $request->first_name,
          'last_name'  => $request->last_name,
          'phone'      => $request->phone,
          'email'      => $request->email,
          //'password'   => Hash::make($password),
          'company_profile_id'   => $request->companyProfileId,
      ];
      $user     = User::updateOrCreate([
          'id' => $request->id
      ], $data);
      session()->flash('success', 'Company User Record updated Successfully!');
      return redirect()->route('company-admin.company-users.index');
    }
    public function passwordUpdate(PasswordRequest $request)
    { //update password for company
        $user = User::find($request->user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Company User Password Reset Successfully!');
        return redirect()->route('company-admin.company-users.index');
    }
}
