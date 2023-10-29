<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DistanceSettingResource extends JsonResource
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
            "weight" => $this->weight,
            "from" => $this->from,
            "to" => $this->to,
            "price" => $this->price,
            "priceType" => $this->id,
        ];
    }
}
