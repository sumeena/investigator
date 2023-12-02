<?php

namespace App\Http\Controllers\Hm;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HmSettingsController extends Controller
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
        return view('hm.settings.index', compact('settings'));
    }
  public function store(Request $request)
    {
      $settingsData = [
          'user_id'       => auth()->id(),
          'assignment_invite' => $request->assignment_invite,
          'assignment_hired_or_closed'     => $request->assignment_hired_or_closed,
          'new_message'     => $request->new_message,
          'assignment_update'     => $request->assignment_update,
          'assignment_invite_message'     => $request->assignment_invite_message,
          'assignment_hired_or_closed_message'     => $request->assignment_hired_or_closed_message,
          'new_message_on_message'     => $request->new_message_on_message,
          'assignment_update_message'     => $request->assignment_update_message,
          'user_role'     => auth()->user()->userRole->role,
          'assignment_confirmation' => $request->assignment_confirmation,
          'assignment_confirmation_on_message' => $request->assignment_confirmation_on_message
      ];
        $user     = Settings::updateOrCreate([
            'id' => $request->id
        ], $settingsData);
        return redirect('hm/settings')->with('success', 'Settings save successfully.');

    }
}
