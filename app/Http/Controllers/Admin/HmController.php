<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Hm\HmRequest;
use App\Http\Requests\Admin\Hm\PasswordRequest;
use App\Mail\UserCredentialMail;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class HmController extends Controller
{
    public function index()
    {   //listing for all hr roles user
        $hiringManagers = User::whereHas('userRole', function ($q) {
            $q->where('role', 'hiring-manager');
        })->paginate(10);

        return view('admin.hm.index', compact('hiringManagers'));
    }

    public function view()
    { //return view for add new hr
        return view('admin.hm.add');
    }

    public function store(HmRequest $request)
    { //for storing data new and update hr
        $password = isset($request->password) ? $request->password : '12345678';
        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'phone'      => $request->phone,
            'email'      => $request->email,
            'password'   => Hash::make($password),
            'role'       => Role::where('role', 'hiring-manager')->first()->id,
        ];
        $user = User::updateOrCreate([
            'id' => $request->id
        ], $data);

        if ($request->id) {
            session()->flash('success', 'Hi Admin , Hiring Manager Record Updated Successfully!');
        } else {
            Mail::to($user)->send(new UserCredentialMail([
                'role'       => $user->userRole->role,
                'first_name' => $user->first_name,
                'last_name'  => $user->last_name,
                'email'      => $user->email,
                'password'   => $password
            ]));
            session()->flash('success', 'Hi Admin , Hiring Manager Record Added Successfully!');
        }

        return redirect()->route('admin.hiring-managers.index');
    }

    public function edit($id)
    {
        //find exist hr user and return data in form
        $hm = User::find($id);
        return view('admin.hm.add', compact('hm'));
    }

    public function delete($id)
    {  //delete hr user from table
        User::find($id)->delete();
        session()->flash('success', 'Hi Admin , Hiring Manager Record Deleted Successfully!');
        return redirect()->route('admin.hiring-managers.index');
    }

    public function resetPassword($id)
    { //show reset password form for company
        $user_id = isset($id) ? $id : '';
        return view('admin.hm.reset-password', compact('user_id'));
    }

    public function passwordUpdate(PasswordRequest $request)
    { //update password for company
        $user = User::find($request->user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Hi Admin , Hiring Manager Password Reset Successfully!');
        return redirect()->route('admin.hiring-managers.index');
    }

}
