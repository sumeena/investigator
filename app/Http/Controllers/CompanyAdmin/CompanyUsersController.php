<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyAdmin\CompanyUserRequest;
use App\Mail\UserCredentialMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\CompanyAdmin\CompanyAdminRequest;
use App\Http\Requests\Admin\CompanyAdmin\PasswordRequest;
use Illuminate\Support\Facades\Mail;

class CompanyUsersController extends Controller
{
    public function index()
    {   //listing for all hr roles user
        $companyAdmins = User::whereHas('userRole', function ($q) {
            $q->whereIn('role', ['company-admin', 'hiring-manager']);
        })->with('CompanyAdminProfile', 'userRole')->paginate(10);

        return view('company-admin.company-users.index', compact('companyAdmins'));
    }

    public function view()
    { //return view for add new hr
        $roles = Role::where('role', 'company-admin')
            ->orWhere('role', 'hiring-manager')->get();
        return view('company-admin.company-users.add', compact('roles'));
    }

    public function store(CompanyUserRequest $request)
    { //for storing data new and update hr
        $password = isset($request->password) ? $request->password : '12345678';
        $data     = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'password'   => Hash::make($password),
            'role'       => $request->role,
        ];
        $user     = User::updateOrCreate([
            'id' => $request->id
        ], $data);

        if ($user->userRole->role == 'hiring-manager') {
            $user->hmCompanyAdmin()->updateOrCreate([
                'company_admin_id' => auth()->id()
            ]);

            Mail::to($user)->send(new UserCredentialMail([
                'role'       => $user->userRole->role,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'email'      => $user->email,
                'password'   => $password
            ]));
        } else {
            $user->hmCompanyAdmin()->delete();
        }

        if ($request->id) {
            session()->flash('success', 'Company User Record Updated Successfully!');
        } else {
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
        return view('company-admin.company-users.add', compact('companyAdmin', 'roles'));
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
