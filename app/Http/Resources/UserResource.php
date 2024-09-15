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
            'gender' => $this->gender,
            'date_of_birth' => $this->date_of_birth,
            'isPremium' => $this->isPremium,
            'plan' => $this->plan,
            "address" => $this->address,
            "admin_type" => $this->role,
            "status" => $this->status,
            "isOnline" => $this->isOnline,
            "last_online" => $this->last_online,
            "user_type" => strtolower($this->user_type),
            "profile_url" => getImageFile($this->image_path),
            "referral_code" => $this->referral_code,
            "user_created_by" => $this->user_created_by ?? new UserResource($this->whenLoaded('user_created_by')),
            "ref_by" =>  $this->ref_by ?? new UserResource($this->whenLoaded('ref_by')),
            "permission" => UserPermissionResource::collection($this->permissions),
            "role" => UserRoleResource::collection($this->roles),
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
