<?php

namespace App\Http\Controllers\Investigator;

use App\Http\Controllers\Controller;
use App\Models\AssignmentUser;
use App\Models\Assignment;
use App\Models\Chat;
use App\Models\User;
use App\Models\ChatMessage;
use App\Models\InvestigatorSearchHistory;
// use App\Models\Invitation;
use App\Models\Notification;
use App\Models\Language;
use App\Models\Media;
use App\Mail\NewMassageMail;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Settings;
use Illuminate\Support\Facades\Mail;
use PhpParser\Node\Expr\Assign;
use Twilio\Rest\Client;

class InvitationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $invitations = AssignmentUser::where('user_id', auth()->id())->with(['assignment', 'user', 'assignment.author.CompanyAdminProfile'])->orderBy('created_at','desc')->paginate(20);
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
        $languages = array();
        $assignmentUser->load(['assignment', 'user', 'assignment.searchHistory', 'chats', 'assignment.chats.chatUsers', 'assignment.chats.chatUsers.media']);

        if(isset($assignmentUser->assignment->searchHistory->languages))
        $languages  = Language::whereIn('id',$assignmentUser->assignment->searchHistory->languages)->pluck('name');

        $authUserId = Auth::id();

        Chat::where(['assignment_id' => $assignmentUser->assignment_id, 'investigator_id' => $authUserId, 'company_admin_id' => $assignmentUser->assignment->user_id])->update(['is_read->investigator' => 1]);

        $chats = Chat::where(['assignment_id' => $assignmentUser->assignment_id, 'investigator_id' => $authUserId, 'company_admin_id' => $assignmentUser->assignment->user_id])->with('chatUsers')->get();

        return view('investigator.invitations.show', compact('assignmentUser', 'languages', 'authUserId', 'chats'));
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
        return redirect()->route('investigator.assignments-listing')->with('success', 'Invitation deleted successfully.');
    }

    /** Send msg */

    public function sendMessage(Request $request) {
        $msg = $request->message;
        $chatId = $request->chat_id;
        $authUserId = Auth::user()->id;
        $chatDetails = Chat::find($chatId);
        $msgSent = ChatMessage::create(array('user_id' => $authUserId, 'chat_id' => $chatId, 'content' => $msg, 'type' => 'text', 'is_delete' => '{"company-admin" : 0 , "investigator" : 0}'));

        $assignmentUser = AssignmentUser::where(['assignment_id' => $chatDetails->assignment_id])->pluck('id');;
        $userDetails = User::where('id', $chatDetails->company_admin_id)->paginate(1);
        $assignment = Assignment::where(['id' => $chatDetails->assignment_id])->paginate(1);

        if($userDetails[0]->role == 2){
          $url=route('company-admin.assignment.show', $chatDetails->assignment_id);
        }else {
          $url=route('hm.assignment.show', $chatDetails->assignment_id);
        }
        $notificationData = [
           'user_id'      => $chatDetails->company_admin_id,
           'from_user_id' =>  auth()->id(),
           'title'        => 'You have received new message on assignment '.$assignment[0]->assignment_id.'',
           'type'         => 'newmassage',
           'url'          => $url,
       ];


        Notification::create($notificationData);
        $settings = Settings::where('user_id', $chatDetails->company_admin_id)->paginate(1);
        if($settings->count() > 0){
          if($settings[0]->new_message == 1 ){


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
              $body = 'You have received new message on assignment '.$assignment[0]->assignment_id.'';
                $sendSms=$this->sendSms($userDetails[0]->phone,$assignment[0]->assignment_id,$body);
                if($sendSms !="sent"){
                  $notificationData = [
                    'first_name' => $userDetails[0]->first_name,
                    'last_name' =>$userDetails[0]->last_name,
                     'title'        => "Please recheck the phone on your profile. We use phone number to send you notifications and you may miss out on important information if it's not valid.
Please correct it as soon as you can.",
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

    public function sendSms($number,$assignmentId, $body)
    {
        $account_sid = env('TWILIO_ACCOUNT_SID');
        $auth_token = env('TWILIO_AUTH_TOKEN');
        $twilio_number = env('SERVICES_TWILIO_PHONE_NUMBER');
        //$twilio_number = "+12569801067"; // Your Twilio phone number

        $client = new Client($account_sid, $auth_token);
         try {
          $client->messages->create(
              '+91'.$number, // Recipient's phone number
              array(
                  'from' => $twilio_number,
                  'body' => $body
              )
          );
        } catch (\Exception $e) {
        // Handle exceptions or errors
        return "Error: " . $e->getMessage();
    }
        return "sent";
    }


    public function assignmentConfirmation($id, $status) {
      $assignmentUser = AssignmentUser::find($id);
      $assignmentDetails = Assignment::find($assignmentUser->assignment_id);
      $hired = ($status == 'ACCEPTED' ? 1 : 0);
      $assignmentStatus = ($status == 'ACCEPTED' ? 'ASSIGNED' : 'OFFER REJECTED');
      $updateAssignmentUser = AssignmentUser::where('id', $id)->update(['status'=> $assignmentStatus, 'hired' => $hired]);
      $updateAssignment = Assignment::where('id', $assignmentUser->assignment_id)->update(['status'=> $assignmentStatus]);

      $notificationData = [
        'user_id'      => $assignmentDetails->user_id,
        'from_user_id' =>  auth()->id(),
        'title'        => $assignmentUser->user->first_name.' '.$assignmentUser->user->last_name.' have '.$status.' your offer on assignment '.$assignmentDetails->assignment_id.'',
        'type'         => 'confirmation',
        'url'          => route('company-admin.assignment.show', $assignmentDetails->id),
    ];


     Notification::create($notificationData);
     $settings = Settings::where('user_id', $assignmentDetails->user_id)->paginate(1);

     if($settings->count() > 0){
       $userDetails = User::where('id', $assignmentDetails->user_id)->paginate(1);
       if($settings[0]->new_message == 1 ){


         $notificationData = [
           'first_name' => $userDetails[0]->first_name,
           'last_name' =>$userDetails[0]->last_name,
            'title'        => $assignmentUser->user->first_name.' '.$assignmentUser->user->last_name.' have '.$status.' your offer on assignment '.$assignmentDetails->assignment_id.'',
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
          $body = $assignmentUser->user->first_name.' '.$assignmentUser->user->last_name.' have '.$status.' your offer on assignment '.$assignmentDetails->assignment_id.'';
             $sendSms=$this->sendSms($userDetails[0]->phone,$assignmentDetails->assignment_id,$body);
             if($sendSms !="sent"){
               $notificationData = [
                 'first_name' => $userDetails[0]->first_name,
                 'last_name' =>$userDetails[0]->last_name,
                  'title'        => "Please recheck the phone on your profile. We use phone number to send you notifications and you may miss out on important information if it's not valid.
Please correct it as soon as you can.",
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









      return redirect()->route('investigator.assignment.show',$id)->with('success', 'OFFER '.$status);
    }

}
