<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications()
    {
        return [
            'read' => auth()->user()->readNotifications,
            'unread' => auth()->user()->unreadNotifications,
            'usertype' => auth()->user()->roles->first()->name,
        ];
    }

    public function markAsRead(Request $request)
    {
        return auth()->user()->notifications->where('id', $request->id)->markAsRead();
    }

    public function markAsReadAndRedirect($id)
    {
        $notification = auth()->user()->notifications->where('id', $id)->first();
        $notification->markAsRead();
        if (auth()->user()->roles->name == 'user') {
            if ($notification->type === 'App\Notifications\NewCommentForPostOwnerNotify') {
                return redirect()->route('users.comment.edit', $notification->data['id']);
            } else {
                return redirect()->back();
            }
        }
    }
}
