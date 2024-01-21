<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use App\Notifications\SendNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class SendLoginNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    public $message;

    public function __construct($user, $message)
    {
        $this->user = $user;
        $this->message = $message;
    }

    public function handle()
    {
        $this->user->notify(new SendNotification($this->user, $this->message));
    }
}
