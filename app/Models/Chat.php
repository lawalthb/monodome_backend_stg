<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Chat belongs to a chat room
    public function chatRoom()
    {
        return $this->belongsTo(ChatRoom::class, 'chat_room_id');
    }

    // Sender of the chat
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // Receiver of the chat
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
