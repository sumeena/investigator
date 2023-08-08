<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Mail\JobInvitationMail;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AssignmentsController extends Controller
{
    public function index()
    {
        $assignments = Assignment::where('user_id', auth()->id())->paginate(10);

        $html = view('company-admin.assignments-response', compact('assignments'))->render();

        return response()->json([
            'data' => $html,
        ]);
    }

    public function create()
    {
        $data = [
            'assignment_id' => Str::upper(Str::random(10)),
        ];

        return response()->json([
            'data' => $data,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'assignment_id' => 'bail|required|string|max:255|unique:assignments',
            'client_id'     => 'bail|required|string|max:255|unique:assignments',
        ]);

        Assignment::create([
            'user_id'       => auth()->id(),
            'assignment_id' => $request->assignment_id,
            'client_id'     => $request->client_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment created successfully!',
        ]);
    }

    public function edit(Assignment $assignment)
    {
        return response()->json([
            'success' => true,
            'message' => 'Data fetched successfully!',
            'data'    => $assignment,
        ]);
    }


    public function update(Request $request, Assignment $assignment)
    {
        $request->validate([
            'client_id' => 'required|string|max:255|unique:assignments,id,:id',
        ]);

        $assignment->update([
            'client_id' => $request->client_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment updated successfully!',
        ]);
    }

    public function destroy(Assignment $assignment)
    {
        $assignment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Assignment deleted successfully!',
        ]);
    }

    public function select2Assignments(Request $request)
    {
        $assignments = Assignment::query()->where('user_id', auth()->id());

        if ($request->get('q')) {
            $assignments->where('assignment_id', 'LIKE', '%' . $request->get('q') . '%')
                ->orWhere('client_id', 'LIKE', '%' . $request->get('q') . '%');
        }

        $assignments = $assignments->get();

        $data = [];

        foreach ($assignments as $assignment) {
            $data[] = [
                'id'   => $assignment->id,
                'text' => Str::upper($assignment->assignment_id) . ' - ' . Str::upper($assignment->client_id),
            ];
        }


        return response([
            'results' => $data
        ]);
    }

    public function invite(Request $request)
    {
        $request->validate([
            'investigator_id' => 'bail|required|integer|exists:users,id',
            'assignments'     => 'bail|required|array',
        ]);

        $investigator = User::find($request->investigator_id);

        $investigator->assignedAssignments()->sync($request->assignments);

        $authUser = auth()->user();

        foreach ($request->assignments as $item) {
            $assignment     = Assignment::find($item);
            $assignmentUser = AssignmentUser::where('assignment_id', $assignment->id)
                ->where('user_id', $investigator->id)->first();

            $notificationData = [
                'user_id'      => $investigator->id,
                'from_user_id' => $authUser->id,
                'title'        => $authUser->first_name . ' ' . $authUser->last_name . ' has invited you to join the assignment',
                'message'      => 'Assigment ID: ' . Str::upper($assignment->assignment_id) . ' - Client ID: ' . Str::upper($assignment->client_id),
                'type'         => Notification::INVITATION,
                'url'          => route('investigator.invitations.show', $assignmentUser->id),
            ];

            Notification::create($notificationData);

            Mail::to($investigator->email)->send(new JobInvitationMail($notificationData));
        }


        return response()->json([
            'success' => true,
            'message' => 'Invitation sent successfully!',
        ]);
    }
}
