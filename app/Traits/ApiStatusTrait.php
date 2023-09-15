<?php

namespace App\Traits;

use App\Models\Notification;


trait ApiStatusTrait
{
    public $successStatus = 200;
    public $failureStatus = 500;
    public $validationFailureStatus = 422;


    public function success($data = [], $msg = NULL)
    {
        $response["success"] = true;
        $response["message"] = $msg ?? __("Successfully done");
        $response["data"] = $data;
        return response()->json($response, $this->successStatus)->header('Content-Type', 'application/json');;
    }

    public function failed($data = [], $msg = NULL)
    {
        $response['success'] = false;
        $response['message'] = $msg ?? __("Something went wrong");
        $response['data'] = $data;
        return response()->json($response, $this->failureStatus)->header('Content-Type', 'application/json');;
    }

    public function error($data = [], $msg = NULL, $code = NULL)
    {
        $response['success'] = false;
        $response['message'] = $msg ?? __("Something went wrong");
        $response['data'] = $data;
        return response()->json($response, $code ?? $this->failureStatus)->header('Content-Type', 'application/json');;
    }

    public function validationError($data = [], $msg = NULL)
    {
        $response['success'] = false;
        $response['message'] = $msg ?? __("Validation error");
        $response['data'] = $data;
        return response()->json($response, $this->validationFailureStatus)->header('Content-Type', 'application/json');;
    }


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

        $notification->user_id = $user_id;
        $notification->text = $message;
        $notification->type = 'App\Notifications\SendNotification';
        $notification->notifiable_type = 'App\User';
        $notification->data = '{"message" : "' . $message . '"}';

        $notification->save();

        if (!$notification) {
            return false;
        }

        return true;

        //return redirect()->route('user.dashboard');
    }
}
