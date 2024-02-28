<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\NewCompanyAdminRegistered;
use App\Mail\SuperAdminMail;
use App\Models\Role;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use App\Notifications\SuperAdminMailNotification;
use App\Rules\CompanyAdminMatchDomain;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;
use Illuminate\Validation\Rules\RequiredIf;
use App\Notifications\WelcomeMailNotification;
use App\Notifications\WelcomeMailNotificationInvestigator;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

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
        // Extract the domain name from the email
        $data['website'] = preg_replace('/^www\./', '', $data['website']);

        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'email'      => ['required', 'string', 'email', 'max:255', 'unique:users', new CompanyAdminMatchDomain($data["website"], $data['role'])],
            'role'       => ['required', 'exists:roles,id'],
            'website'    => ['nullable', 'unique:users,website', new RequiredIf(function () use ($data) {
                return $this->checkIsCompanyAdminRole($data['role']);
            }), 'regex:/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}$/', 'max:255'],
            'password'   => ['required', 'string', 'min:10', 'confirmed', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&()]{10,}$/'],
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
        if($data['role'] == 3){
          $investigatorType = "external";
        }else{
          $investigatorType = "";
        }
        $userData = User::create([
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'role'       => $data['role'],
            'email'      => $data['email'],
            'investigatorType' => $investigatorType,
            'website'    => $this->checkIsCompanyAdminRole($data['role']) ? preg_replace('/^www\./', '', $data['website']) : null,
            'password'   => Hash::make($data['password']),
        ]);

        if($this->checkIsCompanyAdminRole($data['role']))
        {
            $userData->notify(new WelcomeMailNotification($userData));
            $investigators = User::where('role',3)->get();

            foreach($investigators as $investigator)
            {
                $investigator->investigatorBlockedCompanyAdmins()->attach($userData->id);
            }
        }
        else if($this->checkIsInvestigatorRole($data['role']))
        {
            $userData->notify(new WelcomeMailNotificationInvestigator($userData));
        }

        $superAdmin = User::select('email','first_name','last_name','phone')->where('role',USER::ADMIN)->get();
        // $userData->notify(new SuperAdminMailNotification($userData));


        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');

        $twilio_number = env('SERVICES_TWILIO_PHONE_NUMBER'); // Your Twilio phone number

        $client = new Client($account_sid, $auth_token);
        try {
            $client->messages->create(
                '+1' . $superAdmin[0]->phone, // Recipient's phone number
                array(
                    'from' => $twilio_number,
                    'body' => 'New user registered on ilogisticsinc.com'
                )
            );
        } catch (\Exception $e) {
            // Handle exceptions or errors
            return "Error: " . $e->getMessage();
        }
        return "sent";

        Mail::to($superAdmin[0]->email)->send(new SuperAdminMail([
            'role'       => $data['role'],
            'first_name' => $data['first_name'],
            'last_name'  => $data['last_name'],
            'email'      => $data['email'],
            'admin_name' => $superAdmin[0]->first_name.' '.$superAdmin[0]->last_name
        ]));

        return $userData;
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

    private function checkIsInvestigatorRole($roleId)
    {
        $role = Role::find($roleId);
        $hasInvestigatorRole = false;

        if ($role && $role->role == 'investigator') {
            $hasInvestigatorRole = true;
        }

        return $hasInvestigatorRole;
    }
}
