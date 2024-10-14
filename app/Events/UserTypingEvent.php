<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
class UserTypingEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $channel;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, string $channel)
    {
        $this->user = $user;
        $this->channel = $channel;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        Log::info($this->channel);
        return new PrivateChannel($this->channel);
    }

    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'full_name' => $this->user->full_name,
            ],
        ];
    }

    /**
     * Get the event name.
     */
    public function broadcastAs(): string
    {
        return 'user.typing';
    }
}
