<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadSpecializedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>  $this->id,
            "uuid" =>  $this->uuid,
            "user_id" =>  new UserResource($this->user),
            "load_type_name" =>  $this->load_type_name,
            "from" =>  new StateResource($this->RState),
            "to" =>  new StateResource($this->SState),
            "status" =>  $this->status,
            "loadType" => new LoadTypeResource($this->loadType),
            "description" =>  $this->description,
            "created_at" =>  $this->created_at,
            "updated_at" =>  $this->updated_at,
        ];
    }
}
