<?php

namespace App\Http\Controllers\Investigator;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvestigatorSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {

        $settings = Settings::where('user_id', auth()->id())
            ->paginate(1);
        $settings=$settings[0];
        return view('investigator.settings.index', compact('settings'));
    }
  public function store(Request $request)
    {
        $settingsData = [
            'user_id'       => auth()->id(),
            'assignment_invite' => $request->assignment_invite,
            'assignment_hired_or_closed'     => $request->assignment_hired_or_closed,
            'new_message'     => $request->new_message,
            'assignment_update'     => $request->assignment_update,
            'user_role'     => auth()->user()->userRole->role,
        ];
        $user     = Settings::updateOrCreate([
            'id' => $request->id
        ], $settingsData);
        return redirect('investigator/settings')->with('success', 'Settings save successfully.');

    }
}
