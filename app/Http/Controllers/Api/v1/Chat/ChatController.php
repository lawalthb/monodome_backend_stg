<?php

namespace App\Http\Controllers\Api\v1\Chat;

use App\Models\Chat;
use App\Models\User;
use App\Events\ChatEvent;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\ChatResource;

class ChatController extends Controller
{

    use FileUploadTrait, ApiStatusTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $request->validate([
            'sender_id' => 'required|integer',
            'receiver_id' => 'required|integer',
        ]);

        $senderID= $request->sender_id;
        $receiverID= $request->receiver_id;
        // $chat = Chat::where('sender_id',$request->sender_id)->where('receiver_id', $request->receiver_id)->latest()->get();
        $chat = Chat::whereIn('sender_id',[$senderID,$receiverID])->whereIn('receiver_id',[$senderID,$receiverID])->latest()->get();

        return $this->success( ChatResource::collection($chat), 'latest chat');
    }

    public function getMyChatUser(Request $request){

        $senderId= $request->sender_id;
        $receiverID= $request->receiver_id;

        DB::statement("SET SESSION sql_mode=''");

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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sender_id' => 'required|integer',
            'receiver_id' => 'required|integer',
            'message' => 'required|string',
            'file' => 'nullable|file|mimes:png,jpg,jpeg,pdf,doc,docx|max:2024', // Adjust the allowed file types as needed
        ]);

        // Extract validated data
        $validatedData = $request->only(['sender_id', 'receiver_id', 'message']);

        // If a file is provided, upload it and add the file path to the data
        if ($request->hasFile('file')) {
            $validatedData['file_path'] = $this->uploadFile('chat', $request->file('file'));
        }

        // Use updateOrCreate directly with validated data
        $chat = Chat::updateOrCreate(
            [
                'sender_id' => $validatedData['sender_id'],
                'receiver_id' => $validatedData['receiver_id'],
                'message' => $validatedData['message'],
                'send_by' => auth()->id(),
            ],
            $validatedData
        );

        if ($chat) {
            event(new ChatEvent($request->user() ,$chat));

            return $this->success(new ChatResource($chat), 'Created successfully');
        } else {
            return $this->error('An error occurred while registering the Company.');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $chat = Chat::findOrFail($id);

        if($chat->save()){

            return $this->success(new ChatResource($chat), 'Single Chat successfully');
        }else{
            return $this->error('An error occurred while deleting the data.');

        }

    }

    /**
     * Update the specified resource in storage.
     */public function update(Request $request, string $id)
{
    $request->validate([
        'message' => 'required|string',
        'file' => 'nullable|file|mimes:pdf,doc,docx|min:1024', // Adjust the allowed file types and minimum size as needed
    ]);

    $chat = Chat::findOrFail($id);
    // Update the message
    $chat->message = $request->input('message');

    // If a new file is provided, update the file path
    if ($request->hasFile('file')) {
        $this->validate($request, [
            'file' => 'file|mimes:pdf,doc,docx|min:1024', // Validate the file separately
        ]);

        // Upload the new file and update the file path
        $chat->file_path = $this->uploadFile('chat/', $request->file('file'));
    }

    if($chat->save()){

        return $this->success(new ChatResource($chat), 'Chat updated successfully');
    }else{
        return $this->error('An error occurred while deleting the data.');

    }

}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $chat = Chat::where('id',$id)->where("sender_id",auth()->user()->id)->delete();

       if($chat){
        return $this->success([], 'Chat Deleted');

       }else{
        return $this->error('An error occurred while deleting the data.');
       }


    }


    public function test(Request $request){


    }
}
