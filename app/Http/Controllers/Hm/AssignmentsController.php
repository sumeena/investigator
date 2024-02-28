<?php

namespace App\Http\Controllers\Hm;

use App\Http\Controllers\Controller;
use App\Mail\CloseJob;
use App\Mail\HireJob;
use App\Mail\JobInvitationMail;
use App\Models\Assignment;
use App\Models\AssignmentUser;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\CompanyAdminProfile;
use App\Models\CompanyUser;
use App\Models\InvestigatorSearchHistory;
use App\Models\Language;
use App\Models\Media;
use App\Models\Notification;
use App\Models\State;
use App\Models\User;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\NewMassageMail;
use Twilio\Rest\Client;

class AssignmentsController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $userId = auth()->id();
        $parentId = NULL;

        $companyUser = CompanyUser::where('user_id', auth()->id())->exists();

        if($companyUser) {

          if (isset($user->company_profile_id) && $user->company_profile_id !== null) {

          }else {
                session()->flash('error', 'Please tell your company admin to complete company profile first!');
                return redirect()->route('hm.index');
            }

            $user->load([
                'companyAdmin',
                'companyAdmin.company',
                'companyAdmin.company.CompanyAdminProfile',
            ]);

            $CompanyAdminProfile = $user->companyAdmin->company->CompanyAdminProfile;
            $parentProfile = CompanyAdminProfile::find($user->company_profile_id);
            $companyAdmin = $user->companyAdmin?->company;

            if($parentProfile->make_assignments_private == 1)
            $parentId = NULL;
            else
            $parentId = $parentProfile->id;

        }

        $assignments = Assignment::withCount('users')
        ->where(['user_id' => $userId, 'is_delete' => NULL])
        ->when($parentId != '', function ($query) use ($parentId) {
            $query->orWhere(['user_id' => $parentId, 'is_delete' => NULL]);
        })
        ->orderBy('created_at','desc')->paginate(10);

        $html = view('company-admin.assignments-response', compact('assignments'))->render();

        return response()->json([
            'data' => $html,
        ]);
    }


    /** get list of assignments */
    public function assignments_list()
    {
        $user = auth()->user();
        $userId = auth()->id();
        $parentId = NULL;

        $companyUser = CompanyUser::where('user_id', auth()->id())->exists();

        if($companyUser) {

          if (isset($user->company_profile_id) && $user->company_profile_id !== null) {

          }else {
                session()->flash('error', 'Please tell your company admin to complete company profile first!');
                return redirect()->route('hm.index');
            }

            $user->load([
                'companyAdmin',
                'companyAdmin.company',
                'companyAdmin.company.CompanyAdminProfile',
            ]);

            $CompanyAdminProfile = $user->companyAdmin->company->CompanyAdminProfile;
            $parentProfile = CompanyAdminProfile::find($user->company_profile_id);
            // dd($parentProfile);
            $companyAdmin = $user->companyAdmin?->company;

            if($parentProfile->make_assignments_private == 1)
            $parentId = NULL;
            else
            $parentId = $parentProfile->user_id;

        }
        if(isset($_GET['searchby']) && !empty($_GET['searchby']) && isset($_GET['status-select']) && !empty($_GET['status-select']) ){
          $searchBy=$_GET['searchby'];
              $assignments = Assignment::withCount('users')->with('author')->where(function ($query) use ($searchBy) {
                  $query->where('assignment_id', 'like', '%' . $searchBy . '%')
                      ->orWhere('client_id', 'like', '%' . $searchBy . '%');
              })
                ->Where(['status' => $_GET['status-select']])
                ->where(['user_id' => $userId])
                ->when($parentId != '', function ($query) use ($parentId)
                {
                    $query->orWhere('user_id', $parentId);
                })
                ->orderBy('created_at','desc')->paginate(10);
        }
        elseif (isset($_GET['searchby']) && !empty($_GET['searchby'])) {
              $searchBy=$_GET['searchby'];
              $assignments = Assignment::withCount('users')
                ->with('author')
                ->where(function ($query) use ($searchBy) {
                    $query->where('assignment_id', 'like', '%' . $searchBy . '%')
                        ->orWhere('client_id', 'like', '%' . $searchBy . '%');
                })
                ->where(['user_id' => $userId])
                ->when($parentId != '', function ($query) use ($parentId)
                {
                    $query->orWhere('user_id', $parentId);
                })
                ->orderBy('created_at', 'desc')
                ->paginate(10);
        }
        elseif (isset($_GET['status-select']) && !empty($_GET['status-select'])) {
            $assignments = Assignment::withCount('users')->with('author')->where(
                'status', "".$_GET['status-select']."",
              )
              ->where(['user_id' => $userId])
                ->when($parentId != '', function ($query) use ($parentId)
                {
                    $query->orWhere('user_id', $parentId);
                })
              ->orderBy('created_at','desc')->paginate(10);
        }
        else{
            $assignments = Assignment::withCount('users')->where('user_id',$userId)->when($parentId != '', function ($query) use ($parentId)
             {
                $query->orWhere('user_id', $parentId);
               })
               ->where('is_delete', NULL)
               ->orderBy('created_at','desc')->paginate(10);
        }

        return view('company-admin.assignments', compact('assignments'));
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
            'client_id'     => 'bail|required|string|max:255',
        ]);

        $storeAssignment = Assignment::create([
            'user_id'       => auth()->id(),
            'assignment_id' => $request->assignment_id,
            'client_id'     => $request->client_id,
        ]);

        if(isset($request->type) && $request->type == 'clone') {

            $sourceAssignmentID = InvestigatorSearchHistory::where('assignment_id',$request->old_assignment_id)->pluck('id');

            $sourceAssignmentData = InvestigatorSearchHistory::find($sourceAssignmentID[0]);

            $newAssignmentData = $sourceAssignmentData->replicate();
            $newAssignmentData->assignment_id = $storeAssignment->id;
            $savedAssignment = $newAssignmentData->save();

            session()->flash('success', 'Assignment Cloned successfully');

            return route('hm.assignments.edit', ['assignment' => $storeAssignment->id]);

        }

        return response()->json([
            'success' => true,
            'message' => 'Assignment created successfully!',
            'assignmentID' => $storeAssignment->id
        ]);
    }


    public function edit(Assignment $assignment, Request $request)
    {
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

        $assignmentUserDetails = AssignmentUser::where(['assignment_id' => $assignmentId, 'user_id' => $authUserId])->get();

        $hiredStatus = AssignmentUser::where(['assignment_id' => $assignmentId, 'user_id' => $authUserId])->pluck('hired');
        $userAssignmentStatus = $assignmentUserDetails[0]->status;
        $notes = Assignment::where(['id' => $assignmentId])->pluck('notes');

        $assignmentStatus = Assignment::where('id',$assignmentId)->pluck('status');
        $html = view('company-admin.assignment.show-response', compact('messages', 'hiredStatus', 'authUserId', 'chat', 'hiredUser', 'assignmentStatus', 'userAssignmentStatus'))->render();

        return response()->json([
            'data' => $html,
            'notes' => $notes,
            'userAssignmentStatus' => $userAssignmentStatus
        ]);
    }


    /** hire investigator */

    public function hireInvestigator(Request $request) {
        $authUser = auth()->user();
        $authUserId = $request->user_id;
        $assignmentId = $request->assignment_id;
        $assignmentDetails = Assignment::find($assignmentId);
        $offerSents = $assignmentDetails->offer_sent+1;
        $assignmentUser = AssignmentUser::where(['assignment_id' => $assignmentId, 'user_id' => $authUserId])->update(['status' => 'OFFER RECEIVED']);
        Assignment::where('id' , $assignmentId)->update(array('status' => 'OFFER SENT', 'offer_sent'=>$offerSents));

        $assignment = Assignment::find($assignmentId);
        $login=route('login');
        $assignmentUserInfo = AssignmentUser::where(['assignment_id'=>$assignmentId])->get();

        $notificationDataClosed = [
           'title'        => 'The assignment you were invited on has been closed.',
           'login'        => ' to your account so view the details.',
           'loginUrl'        => $login,
           'thanks'        => 'Ilogistics Team',

        ];

        $company_name = '';

        if($authUser->CompanyAdminProfile != null)
        {
            $company_name = $authUser->CompanyAdminProfile->company_name;
        }
        if($authUser->parentCompany != null)
        {
            $company_name = $authUser->parentCompany->company->CompanyAdminProfile?->company_name;
        }

        $notificationDataHired = [
           'title'        => 'Congratulations! An offer is sent to you for a new assignment.',
           'login'        => ' to your account so view the details.',
           'assigmentId'  => 'Assigment ID: ' . Str::upper($assignment->assignment_id),
           'clientId'     => 'Client ID: ' . Str::upper($assignment->client_id),
           'loginUrl'        => $login,
           'companyName'  => 'Company Name: ' .$company_name,
           'thanks'        => 'Ilogistics Team',
         ];
         foreach ($assignmentUserInfo as $item) {
             $investigatorUser = User::find($item->user_id);
             if($item->hired == 1){
                Mail::to($investigatorUser->email)->send(new HireJob($notificationDataHired));
             }else{
                Mail::to($investigatorUser->email)->send(new CloseJob($notificationDataClosed));
             }
             $settings = Settings::where('user_id', $item->id)->paginate(1);

             if($settings->count() > 0){
                  if($settings[0]->assignment_hired_or_closed_message == 1 ){
                    if(!empty($investigatorUser->phone)){
                        $sendSms=$this->sendSms($investigatorUser->phone,$assignment->assignment_id);
                        if($sendSms !="sent"){
                            return response()->json([
                               'error' => true,
                               'message' => $sendSms,
                           ]);
                         }
                    }
                  }
             }
         }
         session()->flash('success', 'Assignment assigned successfully');

    }


     /** Send msg */

     public function sendMessage(Request $request) {
        $msg = $request->message;
        $chatId = $request->chat_id;

        $chatDetails = Chat::find($chatId);

        $msgSent = ChatMessage::create(array('user_id' => $chatDetails->assignment->user_id, 'chat_id' => $chatId, 'content' => $msg, 'type' => 'text', 'is_delete' => '{"investigator": 0, "company-admin": 0}'));
        $authUser =auth();
        $assignmentUser = AssignmentUser::where(['assignment_id' => $chatDetails->assignment->id])->pluck('id');;
        $assignment = Assignment::where(['id' => $chatDetails->assignment_id])->paginate(1);

        $notificationData = [
           'user_id'      => $chatDetails->investigator_id,
           'from_user_id' =>  auth()->id(),
           'title'        => 'You have received new message on assignment '.$assignment[0]->assignment_id.'',
           'type'         => 'newmassage',
           'url'          => route('investigator.assignment.show', $assignmentUser[0]),
       ];


        Notification::create($notificationData);
        $settings = Settings::where('user_id', $chatDetails->investigator_id)->paginate(1);
        if($settings->count() > 0){
          if($settings[0]->new_message == 1 ){
            $userDetails = User::where('id', $chatDetails->investigator_id)->paginate(1);

            $notificationData = [
              'first_name' => $userDetails[0]->first_name,
              'last_name' =>$userDetails[0]->last_name,
               'title'        => 'You have received new message on assignment '.$assignment[0]->assignment_id.'',
               'login'        => ' to your account so view the details.',
               'loginUrl'        => route('login'),
               'thanks'        => 'Ilogistics Team',

            ];

            if(!empty($userDetails[0]->email)){
              Mail::to($userDetails[0]->email)->send(new NewMassageMail($notificationData));
            }
          }
          if($settings[0]->new_message_on_message == 1 ){

            if(!empty($userDetails[0]->phone)){
                $sendSms=$this->sendSms($userDetails[0]->phone,$assignment[0]->assignment_id);
                if($sendSms !="sent"){
                  $notificationData = [
                    'first_name' => $userDetails[0]->first_name,
                    'last_name' =>$userDetails[0]->last_name,
                     'title'        => "Please recheck the phone on your profile. We use phone number to send you notifications and you may miss out on important information if it's not valid. Please correct it as soon as you can.",
                     'login'        => ' to your account so view the details.',
                     'loginUrl'        => route('login'),
                     'phoneupdate' =>"update",
                     'thanks'        => 'Ilogistics Team',

                  ];
                   Mail::to($userDetails[0]->email)->send(new NewMassageMail($notificationData));
                 }
            }
          }
        }
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

        $attachment_file_name = preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $attachment->getClientOriginalName());

        $fileName = time().'_'. $attachment_file_name;
        $fileExt = $attachment->getClientOriginalExtension();
        $filePath = $attachment->storeAs('uploads', $fileName, 'public');

        $attachmentPath = '/storage/' . $filePath;

        $chatId = $request->chat_id;

        $chatDetails = Chat::find($chatId);

        $authUserId = auth()->id();

        $companyUser = CompanyUser::where('user_id', auth()->id())->exists();
        if($companyUser) {
            $parent = CompanyUser::where('user_id', auth()->id())->pluck('parent_id');
            $authUserId = $parent[0];
        }

        $media = Media::create(array( 'file_name' => $attachment_file_name, 'file_ext' => $fileExt));
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
        $assignments = Assignment::query()->where('user_id', auth()->id())
            ->orWhere('user_id', auth()->user()->companyAdmin->parent_id);

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

        $authUser = auth()->user();

            $assignment = Assignment::find($request->assignment);
                $storeAssignmentUser = AssignmentUser::updateOrCreate(['assignment_id' => $assignment->id, 'user_id' => $investigator->id],['assignment_id' => $assignment->id, 'user_id' => $investigator->id]);

                Assignment::where('id',$assignment->id)->update(['status' => 'INVITED']);
                $login=route('login');

                $company_name = '';

                if($authUser->CompanyAdminProfile != null)
                {
                    $company_name = $authUser->CompanyAdminProfile->company_name;
                }
                if($authUser->parentCompany != null)
                {
                    $company_name = $authUser->parentCompany->company->CompanyAdminProfile?->company_name;
                }

                $notificationData = [
                   'user_id'      => $investigator->id,
                   'from_user_id' => $authUser->id,
                   'title'        => 'You have been invited to an assignment by ' .$authUser->first_name . ' ' . $authUser->last_name,
                   'assigmentId'  => 'Assigment ID: ' . Str::upper($assignment->assignment_id),
                   'clientId'     => 'Client ID: ' . Str::upper($assignment->client_id),
                   'companyName'  => 'Company Name: ' .$company_name,
                   'login'        => ' to your account so view the details.',
                   'loginUrl'        => $login,
                   'type'         => Notification::INVITATION,
                   'thanks'        => 'Ilogistics Team',
                   'url'          => route('investigator.assignment.show', $storeAssignmentUser->id),
               ];

            Notification::create($notificationData);

            $companyUser = CompanyUser::where('user_id', auth()->id())->exists();
            if($companyUser) {
                $parent = CompanyUser::where('user_id', auth()->id())->pluck('parent_id');
                $authUser->id = $parent[0];
            }

            $chat = Chat::create(array('assignment_id' => $assignment->id, 'company_admin_id' => $assignment->user_id, 'investigator_id' => $investigator->id, 'is_read' => '{"company-admin":1 , "investigator":0}'));
            ChatMessage::create(array('user_id' => $assignment->user_id, 'chat_id' => $chat->id, 'content' => 'We have invited you to join this assignment. If you are interested, please let us know at your earliest convenience. We can discuss further details and address any questions you may have. Thank you', 'type' => 'text', 'is_delete' => '{"company-admin" : 0 , "investigator" : 0}'));

             Mail::to($investigator->email)->send(new JobInvitationMail($notificationData));
             $settings = Settings::where('user_id', $investigator->id)->paginate(1);

             if($settings->count() > 0){
                  if($settings[0]->assignment_invite_message == 1 ){
                    if(!empty($authUser->phone)){
                        $sendSms=$this->sendSms($investigator->phone,$assignment->assignment_id);
                        if($sendSms !="sent"){
                            return response()->json([
                               'error' => true,
                               'message' => $sendSms,
                           ]);
                         }
                    }
                  }
             }

        return response()->json([
            'success' => true,
            'message' => 'Invitation sent successfully!',
        ]);
    }


    /** save notes in assignment for every investigator  */
    public function saveAssignmentNotes(Request $request) {
        $notes = $request->notes;
        $assignmentId = $request->assignment_id;

        $notesUpdated = Assignment::where(['id'=>$assignmentId])->update(['notes' => $notes]);
        return response()->json([
            'success' => true,
            'message' => 'Noted updated successfully!',
        ]);
    }

    public function getAssignmentNotes(Request $request) {
        $assignmentId = $request->assignment_id;
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
        return redirect()->route('hm.assignments-list');
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
    public function sendSms($number,$assignmentId)
    {
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $twilio_number = env('SERVICES_TWILIO_PHONE_NUMBER');
        //$twilio_number = "+12569801067"; // Your Twilio phone number

        $client = new Client($account_sid, $auth_token);
         try {
          $client->messages->create(
              '+1'.$number, // Recipient's phone number
              array(
                  'from' => $twilio_number,
                  'body' => 'You have received new message on assignment '.$assignmentId.''
              )
          );
        } catch (\Exception $e) {
        // Handle exceptions or errors
        return $e->getMessage();
    }
        return "sent";
    }

    /** Recall Assignment */

    public function assignmentRecall($id,$user_id) {
        $assignmentDetails = Assignment::find($id);
        // Assignment::where('id',$id)->update(['status'=>'OFFER RECALLED']);
        AssignmentUser::where(['assignment_id'=>$assignmentDetails->id, 'user_id' => $user_id])->update(['status'=> 'OFFER RECALLED']);

        $checkForTotalOffersRecalled = AssignmentUser::where(['status'=>'OFFER RECALLED', 'assignment_id' => $id])->count();

        $invitedCount = AssignmentUser::where(['status'=>'INVITED', 'assignment_id' => $id])->count();
        $offerSentCount = AssignmentUser::where(['status'=>'OFFER RECEIVED', 'assignment_id' => $id])->count();

        if($checkForTotalOffersRecalled == $assignmentDetails->offer_sent) {
            Assignment::where('id', $id)->update(['status'=> 'OFFER RECALLED']);
        }

        if($invitedCount <= 0 && $offerSentCount <=0) {
            Assignment::where('id', $id)->update(['status'=> 'OFFER RECALLED']);
        }
        return redirect()->route('hm.assignment.show',$id)->with('success', 'Offer Recalled Successfully');

    }

}
