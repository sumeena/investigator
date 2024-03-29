<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\UserCredentialMail;
use App\Models\InvestigatorLanguage;
use App\Models\Language;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use App\Models\CompanyAdminProfile;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\Investigator\InvestigatorRequest;
use App\Http\Requests\Admin\Investigator\PasswordRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvestigatorController extends Controller
{
    public function index()
    {  //listing for all investigator roles user
        $investigators = User::whereHas('userRole', function ($q) {
            $q->where('role', 'investigator');
        })->paginate(20);
        $companyProfile=array();
        foreach ($investigators as $key => $value)  {
          if ($value->company_profile_id !== null) {
              $companyProfile[$key]=$this->checkCompanyProfile($value->company_profile_id);
          }else{
              $companyProfile[$key]=$this->checkCompanyProfile(0);
          }

        }

        return view('admin.investigator.index', compact('investigators','companyProfile'));
    }

    public function view()
    { //return view for add new investigator
        return view('admin.investigator.add');
    }

    public function store(InvestigatorRequest $request)
    {  //update & store for admin investigator
        $password = isset($request->password) ? $request->password : Str::random(10);
        $data     = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'password'   => Hash::make($password),
            'role'       => Role::where('role', 'investigator')->first()->id,
            'investigatorType' => 'external'
        ];
        $user     = User::updateOrCreate([
            'id' => $request->id
        ], $data);

        if ($request->id) {
            session()->flash('success', 'Hi Admin , Investigator Record Updated Successfully!');
        } else {
            try {
                $mailData = [
                    'role' => $user->userRole->role,
                    'first_name' => $user->first_name,
                    'last_name'  => $user->last_name,
                    'email'      => $user->email,
                    'password'   => $password
                ];
                $mail = Mail::to($user->email)->send(new UserCredentialMail($mailData));

            if (Mail::failures()) {
                print_r(response()->Fail('Sorry! Please try again latter'));
           }

        }
            catch(\Exception $e){
            }
            session()->flash('success', 'Hi Admin , Investigator Record Added Successfully!');
        }

        return redirect()->route('admin.investigators.index');
    }

    public function edit($id)
    {
      /** find exist investigator user and return data in form **/
        $investigator = User::find($id);
        return view('admin.investigator.add', ['investigator' => $investigator]);
    }

    public function delete($id)
    { //delete investigator user from table
        User::find($id)->delete();
        session()->flash('success', 'Hi Admin , Investigator Record Deleted Successfully!');
        return redirect()->route('admin.investigators.index');
    }

    public function investigatorResetPassword($id)
    { //show reset password form for hr
        $user_id = isset($id) ? $id : '';
        return view('admin.investigator.reset-password', compact('user_id'));
    }

    public function investigatorResetUpdate(PasswordRequest $request)
    { //update password for hr
        $user = User::find($request->user_id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        session()->flash('success', 'Hi Admin , Investigator Password Reset Successfully!');
        return redirect()->route('admin.investigators.index');
    }

    public function profileView($id)
    {
        $user = User::findOrFail($id);

        $states          = State::all();
        $languageOptions = Language::all();

        $user->load([
            'investigatorServiceLines',
            'investigatorLicenses',
            'investigatorWorkVehicles',
            'investigatorLanguages',
            'investigatorReview',
            'investigatorEquipment',
            'investigatorDocument',
            'investigatorAvailability',
            'investigatorLicenses.state_data',
            'investigatorAvailability.timezone'
        ]);

        // $serviceLines = $user->investigatorServiceLines;
        $serviceLines = $user->investigatorServiceLines()->with('investigationType')->get();
        $licenses     = $user->investigatorLicenses;
        $workVehicles = $user->investigatorWorkVehicles;
        $languages    = $user->investigatorLanguages;
        $review       = $user->investigatorReview;
        $equipment    = $user->investigatorEquipment;
        $document     = $user->investigatorDocument;
        $availability = $user->investigatorAvailability;

        return view('admin.investigator.view-profile', compact(
            'states',
            'user',
            'serviceLines',
            'licenses',
            'workVehicles',
            'languages',
            'review',
            'equipment',
            'document',
            'availability',
            'languageOptions'
        ));
    }
    public function checkInvestigatorType()
    {
        if(auth()->user()->investigatorType != 'internal'){
          return "Contractor";
        }
    }
    public function checkCompanyProfile($id)
    {
        if(!empty($id) && $id != 0){
          $companyUser = CompanyAdminProfile::find($id);
          return $companyUser->company_name;
        }else{
          return "";
        }
    }
}
