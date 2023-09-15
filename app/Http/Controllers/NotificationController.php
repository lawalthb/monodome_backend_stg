<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;


    public function index(){

        $user = User::find(auth()->user()->id);

        $notifications = $user->notifications()->orderBy('id','desc')->get();

        return response()->json(['notifications' => NotificationResource::collection($notifications)]);


    }
    public function fetchNotification() {
    	$notifications = Notification::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
    	return response()->json(['status' => '1', 'data' => $notifications], 200);
    }

    public function readNotification($id) {
    	$notifications = Notification::find($id);
    	$notifications->is_viewed = 1;
        $notifications->read_at = now();
    	$notifications->save();

       // return $notifications;
        return response()->json(['notifications' => new NotificationResource($notifications)]);
    }
}
