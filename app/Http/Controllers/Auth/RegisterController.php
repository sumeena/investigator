<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Rules\CompanyAdminMatchDomain;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Validation\Rules\RequiredIf;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo()
    {
        switch (auth()->user()->userRole->role) {
            case 'admin':
                $this->redirectTo = 'admin';
                break;
            case 'company-admin':
                $this->redirectTo = 'company-admin/profile';
                break;
            case 'investigator':
                $this->redirectTo = 'investigator/profile';
                break;
            case 'hiring-manager':
                $this->redirectTo = 'hm';
                break;
            default:
                $this->redirectTo = 'login';
                break;
        }

        return $this->redirectTo;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //  $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $roles = Role::where('role', 'company-admin')
            ->orWhere('role', 'investigator')->get();
        return view('auth.register', compact('roles'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if(!empty($data["website"])){
          $data["website"] = $data["pre_link"]."".$data["website"];
        }
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users', new CompanyAdminMatchDomain($data["website"], $data['role'])],
            'role'       => ['required', 'exists:roles,id'],
            'website'    => ['nullable', new RequiredIf(function () use ($data) {
                return $this->checkIsCompanyAdminRole($data['role']);
            }), 'url', 'max:255'],
            'password'   => ['required', 'string', 'min:10', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{10,}$/'],
        ], [
            'password.regex' => 'Password is invalid, please follow the instructions below!',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'role'       => $data['role'],
            'email'      => $data['email'],
            'website'    => $this->checkIsCompanyAdminRole($data['role']) ? $data['website'] : null,
            'password'   => Hash::make($data['password']),
        ]);
    }

    /**
     * Check if the role is a company admin.
     * @param $roleId
     * @return bool
     */
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
