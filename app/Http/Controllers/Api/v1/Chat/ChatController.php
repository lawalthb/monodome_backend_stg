<?php

namespace App\Http\Controllers\Api\v1\Chat;

use Validator;
use App\Models\Chat;
use App\Models\User;
use App\Models\ChatRoom;
use App\Events\ChatEvent;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\UserTypingEvent;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ChatRoomResource;

class ChatController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $request->validate([
            'chat_room_id' => 'required|integer|exists:chat_rooms,id',
        ]);

        $chatRoomId = $request->chat_room_id;

        // Ensure the authenticated user is part of the chat room
        $chatRoom = ChatRoom::findOrFail($chatRoomId);
        if ($chatRoom->sender_id !== Auth::id() && $chatRoom->receiver_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
        }

        $chats = Chat::where('chat_room_id', $chatRoomId)->orderBy('created_at', 'asc')->get();

        return response()->json([
            'success' => true,
            'data' => $chats,
        ]);
    }
     /**
     * Get or create a chat room between two users.
     */
    public function getOrCreateChatRoom(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|integer|exists:users,id',
        ]);

        $senderId = Auth::id();
        $receiverId = $request->receiver_id;

        // Prevent users from chatting with themselves
        if ($senderId === $receiverId) {
            return response()->json(['success' => false, 'message' => 'Cannot create chat with yourself.'], 400);
        }

        // Check if a chat room already exists
        $chatRoom = ChatRoom::where(function($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $senderId)->where('receiver_id', $receiverId);
        })->orWhere(function($query) use ($senderId, $receiverId) {
            $query->where('sender_id', $receiverId)->where('receiver_id', $senderId);
        })->first();

        if (!$chatRoom) {
            $chatRoom = ChatRoom::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'chat_room_id' => $chatRoom->id,
            ],
        ]);
    }

    public function getMyChatUser(Request $request)
    {
        // Fetch all users the authenticated user has chatted with
        $senderId = Auth::id();

        $recentMessages = Chat::where(function ($query) use ($senderId) {
            $query->where('sender_id', $senderId)
                ->orWhere('receiver_id', $senderId);
        })
            ->groupBy('sender_id', 'receiver_id')
            ->select('sender_id', 'receiver_id', 'message')
            ->orderBy('id', 'desc')
            ->limit(30)
            ->get();

        return $this->getFilterRecentMessages($recentMessages, $senderId);
    }

    public function getFilterRecentMessages(Collection $recentMessages, int $senderId): array
    {
        $recentUsersWithMessage = [];
        $usedUserIds = [];
        foreach ($recentMessages as $message) {
            $userId = $message->sender_id == $senderId ? $message->receiver_id : $message->sender_id;
            if (!in_array($userId, $usedUserIds)) {
                $recentUsersWithMessage[] = [
                    'user_id' => $userId,
                    'message' => $message->message
                ];
                $usedUserIds[] = $userId;
            }
        }

        foreach ($recentUsersWithMessage as $key => $userMessage) {
            $recentUsersWithMessage[$key]['name'] = User::where('id', $userMessage['user_id'])->value('full_name') ?? '';
        }

        return $recentUsersWithMessage;
    }


    /**
     * Store a newly created chat message.
     */
    public function store(Request $request)
    {
        $request->validate([
            'chat_room_id' => 'required|integer|exists:chat_rooms,id',
            'sender_id' => 'required|integer|exists:users,id',
            'receiver_id' => 'required|integer|exists:users,id',
            'message' => 'required|string',
            'file' => 'nullable|file|mimes:png,jpg,jpeg,pdf,doc,docx|max:2024',
        ]);

        $senderId = $request->sender_id;
        $receiverId = $request->receiver_id;
        $chatRoomId = $request->chat_room_id;

        if (!in_array(Auth::id(), [$senderId, $receiverId])) {
            return response()->json(['success' => false, 'message' => 'Unauthorized access.'], 403);
        }

        // Ensure the chat room matches the sender and receiver
        $chatRoom = ChatRoom::findOrFail($chatRoomId);
        if (!($chatRoom->sender_id === $senderId && $chatRoom->receiver_id === $receiverId) &&
            !($chatRoom->sender_id === $receiverId && $chatRoom->receiver_id === $senderId)) {
            return response()->json(['success' => false, 'message' => 'Invalid chat room.'], 400);
        }

        // Prepare data for the new chat message
        $validatedData = [
            'chat_room_id' => $chatRoom->id,
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $request->message,
            'send_by' => Auth::id(),
        ];

        // Handle file uploads if present
        if ($request->hasFile('file')) {
            $validatedData['file_path'] = $this->uploadFile('chat', $request->file('file'));
        }

        // Store the chat message
        $chat = Chat::create($validatedData);

        // Broadcast chat event
        event(new ChatEvent(Auth::user(), $chat));

        return response()->json([
            'success' => true,
            'data' => $chat,
            'message' => 'Chat message sent successfully.',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $chat = Chat::findOrFail($id);

        return $this->success(new ChatResource($chat), 'Single Chat successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx|min:1024',
        ]);

        $chat = Chat::findOrFail($id);

        $chat->message = $request->input('message');

        if ($request->hasFile('file')) {
            $chat->file_path = $this->uploadFile('chat/', $request->file('file'));
        }

        if ($chat->save()) {
            return $this->success(new ChatResource($chat), 'Chat updated successfully');
        } else {
            return $this->error('An error occurred while updating the chat.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $chat = Chat::where('id', $id)->where('sender_id', Auth::id())->delete();

        if ($chat) {
            return $this->success([], 'Chat Deleted');
        } else {
            return $this->error('An error occurred while deleting the chat.');
        }
    }

    /**
     * Show chat room and chat history
     */
    public function showChatRoom($id)
    {
        $chatRoom = ChatRoom::with('chats')->findOrFail($id);

        return $this->success(new ChatRoomResource($chatRoom), 'Chat room details retrieved successfully');
    }

    /**
     * Broadcast typing status.
     */
    public function userTyping(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'channel' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $validator->errors(),
            ], 422);
        }

        // event(new UserTypingEvent(Auth::user(), $request->channel))->toOthers();

        broadcast(new UserTypingEvent(Auth::user(), $request->channel))->toOthers();


        return response()->json(['message' => 'Typing event broadcasted'], 200);
    }


    public function test(Request $request) {}
}
