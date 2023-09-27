<?php

namespace App\Http\Controllers\CompanyAdmin;

use App\Http\Controllers\Controller;
use App\Mail\JobInvitationMail;
use App\Mail\HireJob;
use App\Mail\CloseJob;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\Invitation;
use App\Models\Language;
use App\Models\Media;
use App\Models\Notification;
use App\Models\State;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Testing\Assert;

class AssignmentsController extends Controller
{
    public function index()
    {

        $assignments = Assignment::withCount('users')->where(['user_id' => auth()->id(), 'is_delete' => NULL])->orderBy('created_at','desc')->paginate(10);

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

        $storeAssignment = Assignment::create([
            'user_id'       => auth()->id(),
            'assignment_id' => $request->assignment_id,
            'client_id'     => $request->client_id,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Assignment created successfully!',
            'assignmentID' => $storeAssignment->id
        ]);
    }

    /* public function edit(Assignment $assignment)
    {
        $assignment->load(['users', 'searchHistory', 'chats', 'chats.chatUsers', 'chats.chatUsers.media']);

        dd($assignment);
        return response()->json([
            'success' => true,
            'message' => 'Data fetched successfully!',
            'data'    => $assignment,
        ]);
    } */




    /** edit find investigator */

    public function edit(Assignment $assignment, Request $request)
    {
        // dd($request->all());
        $states          = State::all();
        $languageOptions = Language::all();
        $filtered        = false;
        $investigators   = [];
        $assignments     = Assignment::where('user_id', auth()->id())->paginate(10);
        $assignmentCount = Assignment::where('user_id', auth()->id())->count();

        $assignment->load(['users', 'searchHistory']);

        if ($this->checkQueryAvailablity($request)) {
            $filtered      = true;
            $investigators = User::investigatorFiltered($request)
                ->paginate(20);
        }

        if ($request->ajax()) {
            $html = view('company-admin.edit-find-investigator-response', compact('investigators', 'assignmentCount'))->render();

            return response()->json([
                'data' => $html,
            ]);
        }

        return view(
            'company-admin.edit-find-investigator',
            compact(
                'states',
                'languageOptions',
                'filtered',
                'investigators',
                'request',
                'assignments',
                'assignment'
            )
        );
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function checkQueryAvailablity(Request $request): bool
    {
        return $request->get('address')
            || $request->get('city')
            || $request->get('state')
            || $request->get('zipcode')
            || $request->get('license')
            || $request->get('languages')
            || $request->get('surveillance')
            || $request->get('statements')
            || $request->get('distance')
            || $request->get('misc');
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


    /**
     * Display the specified resource.
     *
     * @param Assignment $assignment
     * @return View
     */
    public function show(Assignment $assignment, User $investigator)
    {
        $languages = array();
        $assignment->load(['users', 'searchHistory', 'chats', 'chats.chatUsers', 'chats.chatUsers.media']);

        if(isset($assignment->searchHistory->languages))
        $languages  = Language::whereIn('id',$assignment->searchHistory->languages)->pluck('name');

        $authUserId = Auth::id();

        return view('company-admin.assignment.show', compact('assignment', 'languages', 'authUserId'));
    }


    /**
     * Display the specified resource.
     *
     * @param Assignment $assignment
     * @return View
     */
    public function getAssignmentUser(Request $request)
    {
        $authUserId = $request->user_id;
        $assignmentId = $request->assignment_id;

        if(Auth::user()->role === User::INVESTIGATOR) {
            $authUserId = Auth::id();
        }

        $messages = ChatMessage::where('chat_id', DB::raw("(SELECT MAX(id) from chats WHERE assignment_id = ".$assignmentId . " AND investigator_id = ". $authUserId.")"))->get();

        $chat = Chat::where(['assignment_id' => $assignmentId, 'investigator_id' => $authUserId])->pluck('id');

        $hiredUser = AssignmentUser::where(['assignment_id' => $assignmentId, 'hired' => 1])->pluck('user_id');
        if(count($hiredUser) <= 0)
        $hiredUser[0] = '';

        $hiredStatus = AssignmentUser::where(['assignment_id' => $assignmentId, 'user_id' => $authUserId])->pluck('hired');

        $notes = Assignment::where(['id' => $assignmentId])->pluck('notes');

        $assignmentStatus = Assignment::where('id',$assignmentId)->pluck('status');
        // echo '<pre>';

        $html = view('company-admin.assignment.show-response', compact('messages', 'hiredStatus', 'authUserId', 'chat', 'hiredUser', 'assignmentStatus'))->render();

        return response()->json([
            'data' => $html,
            'notes' => $notes
        ]);
    }


    /** hire investigator */

    public function hireInvestigator(Request $request) {
        $authUser = auth()->user();
        $authUserId = $request->user_id;
        $assignmentId = $request->assignment_id;
        $assignmentUser = AssignmentUser::where(['assignment_id' => $assignmentId, 'user_id' => $authUserId])->update(['hired' => 1]);
        Assignment::where('id' , $assignmentId)->update(array('status' => 'ASSIGNED'));
        $assignment = Assignment::find($assignmentId);
        $login=route('login');
        $assignmentUserInfo = AssignmentUser::where(['assignment_id'=>$assignmentId])->get();
        $notificationDataClosed = [
           'title'        => 'The assignment you were invited on has been closed.',
           'login'        => ' to your account so view the details.',
           'loginUrl'        => $login,
           'thanks'        => 'Ilogistics Team',

        ];
        $notificationDataHired = [
           'title'        => 'Congratulations! You have been selected for a new assignment.',
           'login'        => ' to your account so view the details.',
           'assigmentId'  => 'Assigment ID: ' . Str::upper($assignment->assignment_id),
           'clientId'     => 'Client ID: ' . Str::upper($assignment->client_id),
           'loginUrl'        => $login,
           'companyName'  => 'Company Name: ' .$authUser->parentCompany->company->CompanyAdminProfile?->company_name,
           'thanks'        => 'Ilogistics Team',
         ];
         foreach ($assignmentUserInfo as $item) {
             $investigatorUser = User::find($item->user_id);
             if($item->hired == 1){
                Mail::to($investigatorUser->email)->send(new HireJob($notificationDataHired));
             }else{
                Mail::to($investigatorUser->email)->send(new CloseJob($notificationDataClosed));
             }
         }
    }


    /** Send msg */

    public function sendMessage(Request $request) {
        $msg = $request->message;
        $chatId = $request->chat_id;
        $authUserId = Auth::user()->id;
        $msgSent = ChatMessage::create(array('user_id' => $authUserId, 'chat_id' => $chatId, 'content' => $msg, 'type' => 'text', 'is_delete' => '{"investigator": 0, "company-admin": 0}'));

        if($msgSent) {
            return response()->json([
                'success' => true,
                'message' => 'Message Sent',
            ]);
        }
    }

    /** Send Attachment */
    public function sendAttachmentMessage(Request $request) {
        $attachment = $request->file;

        $fileName = time().'_'.$attachment->getClientOriginalName();
        $fileExt = $attachment->getClientOriginalExtension();
        $filePath = $attachment->storeAs('uploads', $fileName, 'public');

        $attachmentPath = '/storage/' . $filePath;

        $chatId = $request->chat_id;
        $authUserId = Auth::user()->id;
        $media = Media::create(array( 'file_name' => $attachment->getClientOriginalName(), 'file_ext' => $fileExt));
        $msgSent = ChatMessage::create(array('user_id' => $authUserId, 'chat_id' => $chatId, 'content' => $attachmentPath, 'media_id' => $media->id, 'type' => 'media', 'is_read' => '{"company-admin : 0 , "investigator" : 1}'));

        if($msgSent) {
            return response()->json([
                'success' => true,
                'message' => 'Message Sent',
                'attachment' => env('APP_URL').$attachmentPath,
                'ext' => $fileExt
            ]);
        }
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
            'assignment'     => 'bail|required',
        ]);

        $investigator = User::find($request->investigator_id);
        // $investigator->assignedAssignments()->sync($request->assignment);
        $authUser = auth()->user();
        // foreach ($request->assignments as $item) {
            $assignment = Assignment::find($request->assignment);
            /* $assignmentUser = AssignmentUser::where('assignment_id', $assignment->id)
                ->where('user_id', $investigator->id)->first(); */
                $storeAssignmentUser = AssignmentUser::updateOrCreate(['assignment_id' => $assignment->id, 'user_id' => $investigator->id],['assignment_id' => $assignment->id, 'user_id' => $investigator->id]);

                Assignment::where('id',$assignment->id)->update(['status' => 'INVITED']);
                $login=route('login');
                $notificationData = [
                   'user_id'      => $investigator->id,
                   'from_user_id' => $authUser->id,
                   'title'        => 'You have been invited to an assignment by ' .$authUser->first_name . ' ' . $authUser->last_name,
                   'assigmentId'  => 'Assigment ID: ' . Str::upper($assignment->assignment_id),
                   'clientId'     => 'Client ID: ' . Str::upper($assignment->client_id),
                   'companyName'  => 'Company Name: ' .$authUser->CompanyAdminProfile->company_name,
                   'login'        => ' to your account so view the details.',
                   'loginUrl'        => $login,
                   'type'         => Notification::INVITATION,
                   'thanks'        => 'Ilogistics Team',
                   'url'          => route('investigator.assignment.show', $storeAssignmentUser->id),
               ];

            // Invitation::create($invitationData);
            Notification::create($notificationData);

            $chat = Chat::create(array('assignment_id' => $assignment->id, 'company_admin_id' => $authUser->id, 'investigator_id' => $investigator->id, 'is_read' => '{"company-admin":1 , "investigator":0}'));
            ChatMessage::create(array('user_id' => $authUser->id, 'chat_id' => $chat->id, 'content' => 'We have invited you to join this assignment. If you are interested, please let us know at your earliest convenience. We can discuss further details and address any questions you may have. Thank you', 'type' => 'text', 'is_delete' => '{"company-admin" : 0 , "investigator" : 0}'));

             Mail::to($investigator->email)->send(new JobInvitationMail($notificationData));
        // }

        return response()->json([
            'success' => true,
            'message' => 'Invitation sent successfully!',
        ]);
    }


    /** get list of assignments */
    public function assignments_list()
    {
        // $assignments = Assignment::where('user_id', auth()->id())->withCount('invitations')->paginate(10);
        $assignments = Assignment::withCount('users')->where(['user_id' => auth()->id(), 'is_delete' => NULL])->orderBy('created_at','desc')->paginate(10);

        // dd($assignments);

        return view('company-admin.assignments', compact('assignments'));
    }

    /** save notes in assignment for every investigator  */
    public function saveAssignmentNotes(Request $request) {
        $notes = $request->notes;
        $assignmentId = $request->assignment_id;
        // $userId = $request->user_id;
        $notesUpdated = Assignment::where(['id'=>$assignmentId])->update(['notes' => $notes]);
        return response()->json([
            'success' => true,
            'message' => 'Noted updated successfully!',
        ]);
    }

    public function getAssignmentNotes(Request $request) {
        $assignmentId = $request->assignment_id;
        // $userId = $request->user_id;
        $assignmentNotes = Assignment::where(['assignment_id'=>$assignmentId])->pluck('notes');
        return response([
            'notes' => $assignmentNotes
        ]);
    }

    public function markComplete(Assignment $assignment) {
        $assignment->update([
            'status' => 'COMPLETED',
        ]);
        session()->flash('success', 'Assignment updated successfully');
        return redirect()->route('company-admin.assignments-list');
    }

    public function softDeleteAssignment(Assignment $assignment) {
        $assignment->update([
            'is_delete' => 1,
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Assignment deleted successfully!',
        ]);
    }
}
