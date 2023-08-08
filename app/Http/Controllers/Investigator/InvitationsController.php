<?php

namespace App\Http\Controllers\Investigator;

use App\Http\Controllers\Controller;
use App\Models\AssignmentUser;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InvitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $invitations = AssignmentUser::where('user_id', auth()->id())
            ->with(['assignment', 'user'])
            ->paginate(20);

        return view('investigator.invitations.index', compact('invitations'));
    }

    /**
     * Display the specified resource.
     *
     * @param AssignmentUser $assignmentUser
     * @return View
     */
    public function show(AssignmentUser $assignmentUser)
    {
        $assignmentUser->load(['assignment', 'user']);

        return view('investigator.invitations.show', compact('assignmentUser'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AssignmentUser $assignmentUser
     * @return RedirectResponse
     */
    public function destroy(AssignmentUser $assignmentUser)
    {
        $assignmentUser->delete();

        return redirect()->route('investigator.invitations.index')
            ->with('success', 'Invitation deleted successfully.');
    }
}
