<?php

namespace App\Http\Controllers\Investigator;

use App\Http\Controllers\Controller;
use App\Models\User;

class CompanyAdminsController extends Controller
{
    public function index()
    {
        $companyAdmins = User::whereHas('userRole', function ($q) {
            $q->where('role', 'company-admin');
        })
            ->whereHas('companyAdminProfile')
            ->with('companyAdminProfile')
            ->paginate(20);

        return view('investigator.company_admins', compact('companyAdmins'));
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
