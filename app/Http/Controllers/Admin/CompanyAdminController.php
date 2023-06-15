<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserCredentialMail;
use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\CompanyAdmin\CompanyAdminRequest;
use App\Http\Requests\Admin\CompanyAdmin\PasswordRequest;
use Illuminate\Support\Facades\Mail;

class CompanyAdminController extends Controller
{
    public function index()
    {   //listing for all hr roles user
        $companyAdmins = User::whereHas('userRole', function ($q) {
            $q->where('role', 'company-admin');
        })->with('CompanyAdminProfile')->paginate(10);

        return view('admin.company-admin.index', compact('companyAdmins'));
    }

    public function view()
    { //return view for add new hr
        return view('admin.company-admin.add');
    }

    public function store(CompanyAdminRequest $request)
    { //for storing data new and update hr
        $password = isset($request->password) ? $request->password : '12345678';
        $data     = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'password'   => Hash::make($password),
            'role'       => Role::where('role', 'company-admin')->first()->id,
        ];

        $user = User::updateOrCreate([
            'id' => $request->id
        ], $data);

        if ($request->id) {
            session()->flash('success', 'Hi Admin , Company Admin Record Updated Successfully!');
        } else {
            Mail::to($user)->send(new UserCredentialMail([
                'role'       => $user->userRole->role,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'email'      => $user->email,
                'password'   => $password
            ]));
            session()->flash('success', 'Hi Admin , Company Admin Record Added Successfully!');
        }

        return redirect()->route('admin.company-admins.index');
    }

    public function edit($id)
    {
        //find exist hr user and return data in form
        $companyAdmin = User::find($id);
        return view('admin.company-admin.add', compact('companyAdmin'));
    }

    public function delete($id)
    {  //delete hr user from table
        User::find($id)->delete();
        session()->flash('success', 'Hi Admin , Company Admin Record Deleted Successfully!');
        return redirect()->route('admin.company-admins.index');
    }

    public function resetPassword($id)
    { //show reset password form for company
        $user_id = isset($id) ? $id : '';
        return view('admin.company-admin.reset-password', compact('user_id'));
    }

    public function passwordUpdate(PasswordRequest $request)
    { //update password for company
        $user = User::find($request->user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Hi Admin , Company Admin Password Reset Successfully!');
        return redirect()->route('admin.company-admins.index');
    }

    public function viewProfile($id)
    {
        $user = User::findOrFail($id);

        $user->load([
            'CompanyAdminProfile'
        ]);

        $companyAdminProfile = $user->CompanyAdminProfile;

        return view('admin.company-admin.profile-view', compact(
            'companyAdminProfile'
        ));
    }
}
