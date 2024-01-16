<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        //draft , confirmed , Published
        return [
            'id' => $this->id,
            'title' => $this->title,
            'body' => $this->body,
            'image' =>  getImageFile($this->image),
            'status' => $this->status ==0 ? 'draft' : 'Published',
            'category' => new CategoryResource($this->category),
            'user' => new UserResource($this->user),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

    }
}
