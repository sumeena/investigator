<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo;

    public function redirectTo()
    {
        $user = auth()->user();

        switch ($user->userRole->role) {
            case 'admin':
                $this->redirectTo = 'admin';
                break;
            case 'company-admin':
                $this->redirectTo = 'company-admin/profile';
                if ($user->company_profile_id !== null) {
                    $this->redirectTo = 'company-admin'; //'company';
                }
                break;
            case 'investigator':
                $this->redirectTo = 'investigator/profile';
                if ($user->is_investigator_profile_submitted) {
                    $this->redirectTo = 'investigator';
                }
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
        //$this->middleware('guest')->except('logout');
    }
}
