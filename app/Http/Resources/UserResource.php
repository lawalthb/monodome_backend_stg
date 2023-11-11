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
            'phone_number' => $this->phone_number,
            'isPremium' => $this->isPremium,
            "address" => $this->address,
            "admin_type" => $this->role,
            "user_type" => strtolower($this->user_type),
            "profile_url" => getImageFile($this->image_path),
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
            "user_created_by" => new UserResource($this->whenLoaded('user_created_by')),
            "role" => UserRoleResource::collection($this->roles),
           // "orders" =>  OrderResource::collection($this->whenLoaded('order')),
          //  "roles" => $this->roles,
           // "permissions" => $this->roles,
        ];
    }
}
