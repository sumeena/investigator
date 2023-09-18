<?php

namespace App\Http\Controllers\Investigator;

use App\Http\Controllers\Controller;
use App\Models\AssignmentUser;
use App\Models\Chat;
use App\Models\ChatMessage;
use App\Models\InvestigatorSearchHistory;
// use App\Models\Invitation;
use App\Models\Language;
use App\Models\Media;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $msgSent = ChatMessage::create(array('user_id' => $authUserId, 'chat_id' => $chatId, 'content' => $msg, 'type' => 'text', 'is_delete' => '{"company-admin" : 0 , "investigator" : 0}'));

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

}
