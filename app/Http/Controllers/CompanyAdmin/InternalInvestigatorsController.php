<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CompanyAdmin\InternalInvestigatorRequest;
use App\Notifications\WelcomeMailNotification;
use App\Models\Role;
use App\Models\User;
use App\Models\CompanyUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Admin\CompanyAdmin\PasswordRequest;
use App\Models\InvestigatorType;
use Illuminate\Support\Facades\Mail;

class InternalInvestigatorsController extends Controller
{
    public function index()
    {   //listing for all investigator roles user
        $user = auth()->user();
        $role = Auth::user()->role;
        if($role == 4){
          $investigators = User::where('investigatorType', "internal")->where('company_profile_id', $user->company_profile_id)->paginate(20);
            return view('company-admin.internal-investigators.index', compact('investigators','role'));
        }
        $investigators = User::whereHas('userRole', function ($q) {
            $q->where('role', 'investigator');
        })->whereHas('companyAdmin', function ($q) {
            $q->where('parent_id', auth()->id());
        })->with('CompanyAdminProfile', 'userRole')->paginate(20);

        return view('company-admin.internal-investigators.index', compact('investigators','role'));
    }

    public function add()
    {
        $user = auth()->user();
        $user->load(['parentCompany', 'parentCompany.company']);
        return view('company-admin.internal-investigators.add', compact('user'));
    }

    public function store(InternalInvestigatorRequest $request)
    {


        // dd($request->all());
        config(['mail.from.address' => 'admin@stagingwebsites.info']);

        $role = Role::where('role', 'investigator')->first();
        // check at least one service line is selected
        if (!$this->checkServiceLineIsChecked($request)) {
            return throw ValidationException::withMessages(
                ['investigation_type' => 'Please select at least one service line.']
            );
        }
        $data = [
            'first_name' => $request->first_name,
            'last_name'  => $request->last_name,
            'email'      => $request->email,
            'investigatorType'      => "internal",
            'company_profile_id'      => $request->company_profile_id,
            'role'       => $role->id ?? 3,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user = User::updateOrCreate([
            'id' => $request->id
        ], $data);

        // Save service lines data

        if (count($request->investigation_type)) {
            $user->investigatorServiceLines()->delete();
            foreach ($request->investigation_type as $investigation_type) {
                if (!isset($investigation_type["type"]))
                    continue;

                if (isset($investigation_type['misc_service_name'])) {
                    foreach ($investigation_type['misc_service_name'] as $key => $misc_service) {
                        if ($misc_service) {
                            $serviceLinesInvestigationTypes = InvestigatorType::firstOrCreate(
                                ['type_name' => $misc_service]
                            );

                            $user->investigatorServiceLines()->updateOrCreate([
                                'investigation_type_id' => $serviceLinesInvestigationTypes->id
                            ], [
                                'case_experience'    => $investigation_type["case_experience"][$key],
                                'years_experience'   => $investigation_type["years_experience"][$key],
                                'hourly_rate'        => $investigation_type["hourly_rate"][$key],
                                'travel_rate'        => $investigation_type["travel_rate"][$key],
                                'milage_rate'        => $investigation_type["milage_rate"][$key],
                            ]);
                        }
                    }
                }
                if(isset($investigation_type['service_name'])) {
                $serviceLinesInvestigationTypes = InvestigatorType::firstOrCreate(
                    ['type_name' => $investigation_type['service_name']]
                );
                $user->investigatorServiceLines()->updateOrCreate([
                    'investigation_type_id' => $serviceLinesInvestigationTypes->id
                ], [
                    'investigation_type' => $investigation_type['service_name'],
                    'case_experience'    => $investigation_type["case_experience"],
                    'years_experience'   => $investigation_type["years_experience"],
                    'hourly_rate'        => $investigation_type["hourly_rate"],
                    'travel_rate'        => $investigation_type["travel_rate"],
                    'milage_rate'        => $investigation_type["milage_rate"],
                ]);
            }
            }
        }
        
        /* if (count($request->investigation_type)) {
            $user->investigatorServiceLines()->delete();
            foreach ($request->investigation_type as $investigation_type) {
                if (!isset($investigation_type["type"]))
                    continue;

                $user->investigatorServiceLines()->create([
                    'investigation_type' => $investigation_type["type"],
                    'case_experience'    => $investigation_type["case_experience"],
                    'years_experience'   => $investigation_type["years_experience"],
                    'hourly_rate'        => $investigation_type["hourly_rate"],
                    'travel_rate'        => $investigation_type["travel_rate"],
                    'milage_rate'        => $investigation_type["milage_rate"],
                ]);
            }
        } */
        // Create company user data
        CompanyUser::updateOrCreate([
            'user_id'   => $user->id,
            'parent_id' => auth()->id()
        ]);

        if ($request->id) {
            session()->flash('success', 'Internal Investigator Record Updated Successfully!');
        } else {

          $user->notify(new WelcomeMailNotification($user,$request->password));
            session()->flash('success', 'Internal Investigator Record Added Successfully!');
        }

        return redirect()->route('company-admin.internal-investigators.index');
    }

    public function edit($id)
    {

        $investigator = User::findOrFail($id);
        $user         = auth()->user();

        $user->load(['parentCompany', 'parentCompany.company']);
        $investigator->load(['investigatorServiceLines']);

        $serviceLines    = $investigator->investigatorServiceLines()->with('investigationType')->get();

        $survServiceLine =  $statServiceLine = '';
        $miscServiceLine = array();

        foreach ($serviceLines as $serviceLine) {
            if ($serviceLine->investigationType['type_name'] == 'surveillance')
                $survServiceLine = $serviceLine;
            else if ($serviceLine->investigationType['type_name'] == 'statements')
                $statServiceLine = $serviceLine;
            else
                $miscServiceLine[] = $serviceLine;
            // if($serviceLine->investigationType['type_name'] == 'statements')
        }

        /* $survServiceLine = $investigator->investigatorServiceLines()->where('investigation_type', 'surveillance')->first();
        $statServiceLine = $investigator->investigatorServiceLines()->where('investigation_type', 'statements')->first();
        $miscServiceLine = $investigator->investigatorServiceLines()->where('investigation_type', 'misc')->first(); */
        return view('company-admin.internal-investigators.add', compact('investigator', 'user','serviceLines',
        'survServiceLine',
        'statServiceLine',
        'miscServiceLine'));
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
    /**
     * Check service line is checked
     * @param Request $request
     * @return bool
     */
    private function checkServiceLineIsChecked(Request $request)
    {
        $isCheck = false;
        foreach ($request->investigation_type as $investigation_type) {
            if (isset($investigation_type["type"])) {
                $isCheck = true;
                break;
            }
        }

        return $isCheck;
    }


    public function searchForServiceLine(Request $request)
    {
        return InvestigatorType::where('type_name', 'LIKE', '%' . $request->q . '%')->get();
    }
}
