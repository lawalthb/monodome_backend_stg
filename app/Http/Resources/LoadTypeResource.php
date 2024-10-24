<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadTypeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>$this->id,
            "uuid" =>$this->uuid,
            "name" =>$this->name,
            "slug" =>$this->slug,
            "is_active" =>$this->is_active,
        ];
    }
}
