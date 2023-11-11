<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource
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
            "receiver" =>  new UserResource($this->receiver),
            "message" => $this->message,
            "file_path" => getImageFile($this->file_path),
        ];
    }
}
