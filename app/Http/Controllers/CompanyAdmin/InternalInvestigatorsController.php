<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyAdmin\InternalInvestigatorRequest;
use App\Notifications\WelcomeMailNotification;
use App\Models\Role;
use App\Models\User;
use App\Models\CompanyUser;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\CompanyAdmin\PasswordRequest;
use Illuminate\Support\Facades\Mail;

class InternalInvestigatorsController extends Controller
{
    public function index()
    {   //listing for all investigator roles user
        $investigators = User::whereHas('userRole', function ($q) {
            $q->where('role', 'investigator');
        })->whereHas('companyAdmin', function ($q) {
            $q->where('parent_id', auth()->id());
        })->with('CompanyAdminProfile', 'userRole')->paginate(20);

        return view('company-admin.internal-investigators.index', compact('investigators'));
    }

    public function add()
    {
        $user = auth()->user();
        $user->load(['parentCompany', 'parentCompany.company']);
        return view('company-admin.internal-investigators.add', compact('user'));
    }

    public function store(InternalInvestigatorRequest $request)
    {
        $role = Role::where('role', 'investigator')->first();

        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'investigatorType'      => "internal",
            'role'       => $role->id ?? 3,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user = User::updateOrCreate([
            'id' => $request->id
        ], $data);

        // Create company user data
        CompanyUser::updateOrCreate([
            'user_id'   => $user->id,
            'parent_id' => auth()->id()
        ]);

        if ($request->id) {
            session()->flash('success', 'Internal Investigator Record Updated Successfully!');
        } else {
          
          $user->notify(new WelcomeMailNotification($user,$request->password));
            // Mail::to($user)->send(new UserCredentialMail([
            //     'role'       => $user->userRole->role,
            //     'first_name' => $user->first_name,
            //     'last_name'  => $user->last_name,
            //     'email'      => $user->email,
            //     'password'   => $request->password
            // ]));
            session()->flash('success', 'Internal Investigator Record Added Successfully!');
        }

        return redirect()->route('company-admin.internal-investigators.index');
    }

    public function edit($id)
    {
        $investigator = User::findOrFail($id);
        $user         = auth()->user();
        $user->load(['parentCompany', 'parentCompany.company']);
        return view('company-admin.internal-investigators.add', compact('investigator', 'user'));
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        session()->flash('success', 'Internal Investigator Record Deleted Successfully!');
        return redirect()->route('company-admin.internal-investigators.index');
    }

    public function resetPassword($id)
    {
        $user    = User::findOrFail($id);
        $user_id = $user->id;
        return view('company-admin.internal-investigators.reset-password', compact('user_id'));
    }

    public function passwordUpdate(PasswordRequest $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Internal Investigator Password Reset Successfully!');
        return redirect()->route('company-admin.internal-investigators.index');
    }
}
