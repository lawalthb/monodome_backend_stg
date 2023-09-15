<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    public function fetchNotification() {
    	$notifications = Notification::where('user_id', Auth::user()->id)->orderBy('id','desc')->get();
    	return response()->json(['status' => '1', 'data' => $notifications], 200);
    }

    public function readNotification($id) {
    	$notifications = Notification::find($id);
    	$notifications->is_viewed = 1;
    	$notifications->save();
    	return response()->json(['status' => '1', 'data' => $notifications], 200);
    }
}
