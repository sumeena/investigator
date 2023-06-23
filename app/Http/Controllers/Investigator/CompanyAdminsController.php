<?php

namespace App\Http\Controllers\Investigator;

use App\Http\Controllers\Controller;
use App\Models\CompanyUser;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class CompanyAdminsController extends Controller
{
    public function index()
    {
        // $companyAdmins = array();
        $companyAdmins = User::whereIn('id', function($query){
                            $query->select('parent_id')
                            ->from(with(new CompanyUser())->getTable())
                            ->groupBy('parent_id');
                        })
                        ->with('companyAdminProfile')
                        ->paginate();

                        /* dd($companyAdminsQueryResult);

                        foreach($companyAdminsQueryResult as $companyAdmin) {
                            if($companyAdmin->companyAdminProfile)
                            {
                                $companyAdmins[] = $companyAdmin;
                            }
                        }

             */
            $profilesCount = 0;
        return view('investigator.company_admins', compact('companyAdmins','profilesCount'));
    }

    public function blockUnblockCompanyAdmin($companyAdminId)
    {
        $investigator = auth()->user();

        if ($investigator->checkIsBlockedCompanyAdmin($companyAdminId)) {
            $investigator->investigatorBlockedCompanyAdmins()->detach($companyAdminId);
            $message = 'Company Admin unblocked successfully.';
        } else {
            $investigator->investigatorBlockedCompanyAdmins()->attach($companyAdminId);
            $message = 'Company Admin blocked successfully.';
        }

        session()->flash('success', $message);

        return redirect()->back();
    }
}
