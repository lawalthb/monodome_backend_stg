<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleTypeResource extends JsonResource
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
            "updated_at" =>$this->updated_at,
            "created_at" =>$this->created_at,
        ];
    }
}
