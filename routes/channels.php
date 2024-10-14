<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('chat-room.{chatRoomId}', function ($user, $chatRoomId) {

    $chatRoom = \App\Models\ChatRoom::find($chatRoomId);

    if (!$chatRoom) {
        return false;
    }

    return $user->id === $chatRoom->sender_id || $user->id === $chatRoom->receiver_id;
});

Broadcast::channel('messenger.{senderId}.{receiverId}', function ($user, $senderId, $receiverId) {

    return $user->id === (int) $senderId || $user->id === (int) $receiverId;
});
