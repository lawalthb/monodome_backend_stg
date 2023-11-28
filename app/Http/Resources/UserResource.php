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
            "status" => $this->status,
            "user_type" => strtolower($this->user_type),
            "profile_url" => getImageFile($this->image_path),
            "referral_code" => $this->referral_code,
            "user_created_by" => new UserResource($this->whenLoaded('user_created_by')),
            "ref_by" =>  new UserResource($this->whenLoaded('ref_by')),
            "role" => UserRoleResource::collection($this->roles),
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
           // "orders" =>  OrderResource::collection($this->whenLoaded('order')),
          //  "roles" => $this->roles,
           // "permissions" => $this->roles,
        ];
    }
}
