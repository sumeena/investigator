<?php

namespace App\Http\Controllers\Hm;

use App\Http\Controllers\Controller;
use App\Mail\UserCredentialMail;
use App\Models\InvestigatorLanguage;
use App\Models\Language;
use App\Models\Role;
use App\Models\State;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Admin\Investigator\InvestigatorRequest;
use App\Http\Requests\Admin\Investigator\PasswordRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class InvestigatorController extends Controller
{
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

        $serviceLines = $user->investigatorServiceLines;
        $licenses     = $user->investigatorLicenses;
        $workVehicles = $user->investigatorWorkVehicles;
        $languages    = $user->investigatorLanguages;
        $review       = $user->investigatorReview;
        $equipment    = $user->investigatorEquipment;
        $document     = $user->investigatorDocument;
        $availability = $user->investigatorAvailability;

        return view('company-admin.investigator.view-profile', compact(
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
}
