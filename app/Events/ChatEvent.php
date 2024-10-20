<?php

namespace App\Events;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ChatEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $chat;

    /**
     * Create a new event instance.
     */
    public function __construct(User $user, Chat $chat)
    {
        $this->user = $user;
        $this->chat = $chat;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat-room.' . $this->chat->chat_room_id);
    }

    public function broadcastWith()
    {
        return [
            'user' => [
                'id' => $this->user->id,
                'full_name' => $this->user->full_name,
            ],
            'message' => $this->chat->message,
            'created_at' => $this->chat->created_at->format('Y-m-d H:i:s'),
        ];
    }

    public function broadcastAs()
    {
        return 'user-chat';
    }
}
