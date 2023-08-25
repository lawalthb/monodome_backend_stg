<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            "email" => $this->email,
            "full_name" => $this->full_name,
            "address" => $this->address,
            "role" => $this->role,
            "user_type" => $this->user_type,
            "profile_url" => getImageFile($this->image_path),
          //  "roles" => $this->roles,
           // "permissions" => $this->roles,
        ];
    }
}
