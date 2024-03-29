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
use App\Mail\NewCompanyAdminRegistered;
use App\Models\CompanyAdminProfile;
use App\Models\CompanyUser;
use Illuminate\Support\Facades\Mail;
use App\Rules\CompanyAdminMatchDomain;
use Exception;
use Illuminate\Validation\Rules\RequiredIf;
use Illuminate\Support\Str;

class CompanyAdminController extends Controller
{
    public function index()
    {   //listing for all hr roles user
        $companyAdmins = User::whereHas('userRole', function ($q) {
            $q->where('role', 'company-admin');
        })->with('CompanyAdminProfile')->with(['parentCompany' => function ($query) {
            $query->with('company');
        }])->paginate(20);
        return view('admin.company-admin.index', compact('companyAdmins'));
    }

    public function view()
    { //return view for add new hr
        $companyAdmins = User::whereHas('userRole', function ($q) {
            $q->where('role', 'company-admin');
        })->whereNotNull('website')->where('website', '!=', '')->get();
        return view('admin.company-admin.add', compact('companyAdmins'));
    }

    /**
     * Store Company Admin
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $company_profile_id = NULL;
        if (!empty($request->company_admin)) {
            $company_name = $request->company_name_edit;
            $company_profile_id = CompanyAdminProfile::where('user_id',$request->company_admin)->pluck('id');
            $company_profile_id = $company_profile_id[0];
            $request->website = null;
            $website = User::find($request->company_admin)->website ?? null;
        } else {
            $company_name = $request->company_name;
            $website = $request->website;
        }
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->id, new CompanyAdminMatchDomain($website, $request->role)],
            'role' => ['required', 'exists:roles,id'],
            'website' => ['nullable', 'regex:/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/', 'max:255', 'unique:users'],
        ]);
        $password = isset($request->password) ? $request->password : Str::random(10);
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => Hash::make($password),
            'role' => Role::where('role', 'company-admin')->first()->id,
            'company_profile_id'=>$company_profile_id
        ];

        if (empty($request->company_admin)) {
            $data['website'] = preg_replace('/^www\./', '', $request->website);
        }
        $user = User::updateOrCreate([
            'id' => $request->id
        ], $data);
        

        if ($company_name) {
            CompanyAdminProfile::updateOrCreate([
                'user_id' => $user->id ], ['company_name' => $company_name ]
            );
        }

        if (!empty($request->company_admin) && empty($request->id)) {
            $parent = User::find($request->company_admin)->id ?? null;
            $company_users = CompanyUser::create(['user_id' => $user->id, 'parent_id' => $parent]);
        }

        if(empty($request->company_admin))
        {
            $investigators = User::where('role',3)->get();

            foreach($investigators as $investigator)
            {
                $investigator->investigatorBlockedCompanyAdmins()->attach($user->id);
                // Mail::to($investigator->email)->send(new NewCompanyAdminRegistered($userData));
            }
        }

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
        $companyAdmins = User::whereHas('userRole', function ($q) {
            $q->where('role', 'company-admin');
        })->whereNotNull('website')->where('website', '!=', '')->get();
        $companyAdmin = User::with('parentCompany')->find($id);
        $companyAdminProfile = CompanyAdminProfile::where('user_id',$id)->get();        
        return view('admin.company-admin.add', compact('companyAdmin', 'companyAdmins','companyAdminProfile'));
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
            'CompanyAdminProfile',
            'companyAdmin',
            'companyAdmin.company',
            'companyAdmin.company.CompanyAdminProfile'
        ]);

        $CompanyAdminProfile = $user->CompanyAdminProfile;
        $parentProfile = $user->companyAdmin?->company?->CompanyAdminProfile;

        return view('admin.company-admin.profile-view', compact(
            'CompanyAdminProfile',
            'parentProfile',
            'user'
        ));
    }

    private function checkIsCompanyAdminRole($roleId)
    {
        $role = Role::find($roleId);

        $hasCompanyAdminRole = false;

        if ($role && $role->role == 'company-admin') {
            $hasCompanyAdminRole = true;
        }

        return $hasCompanyAdminRole;
    }
}
