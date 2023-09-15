<?php

namespace App\Traits;

use App\Models\Notification;

trait SendNotification
{
    private function send($text, $user_type, $target_url = null, $user_id = null)
    {
        $notification = new Notification();
        $notification->user_id = $user_id;
        $notification->text = $text;
        $notification->target_url = $target_url;
        $notification->user_type = $user_type;
        $notification->save();
        return $notification;
    }

    public function createNotification($user_id, $message)
    {

        $notification = new Notification();

        //$notification->user_id = $user_id;
        $notification->text = $message;
        $notification->type = 'App\Notifications\SendNotification';
        $notification->notifiable_type = 'App\Models\User';
        $notification->data = '{"message" : "' . $message . '"}';

        $notification->save();

        if (!$notification) {
            return false;
        }

        return true;

        //return redirect()->route('user.dashboard');
    }
}
