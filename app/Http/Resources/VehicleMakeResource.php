<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleMakeResource extends JsonResource
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
            "name" => $this->name,
            "uuid" => $this->uuid,
            "code" => $this->code,
            "logo" =>  getImageFile($this->logo_path),
            "updated_at" => $this->updated_at,
            "created_at" => $this->created_at,
        ];
    }
}
