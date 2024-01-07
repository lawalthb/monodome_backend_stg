<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'comment' => $this->comment,
            'status' => $this->status,
            'blog' => new BlogResource($this->blog),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
