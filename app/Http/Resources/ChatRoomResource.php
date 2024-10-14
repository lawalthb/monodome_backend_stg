<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "sender" => new UserResource($this->sender),
            "receiver" => new UserResource($this->receiver),
            "chat_history" => ChatResource::collection($this->chats),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
