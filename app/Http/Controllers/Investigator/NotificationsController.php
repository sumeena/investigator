<?php

namespace App\Http\Controllers\Investigator;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class NotificationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->id())
            ->with(['owner', 'sender'])
            ->paginate(20);

        return view('investigator.notifications.index', compact('notifications'));
    }

    /**
     * Display the specified resource.
     *
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function show(Notification $notification)
    {
        $notification->update(['is_read' => true]);

        return redirect($notification->url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Notification $notification
     * @return RedirectResponse
     */
    public function destroy(Notification $notification)
    {
        $notification->delete();

        return redirect()->route('investigator.notifications.index')
            ->with('success', 'Notification deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return RedirectResponse
     */
    public function markAllRead()
    {
        Notification::where('user_id', auth()->id())->update(['is_read' => true]);

        return redirect()->route('investigator.notifications.index')
            ->with('success', 'Marked all notifications as read.');
    }
}
