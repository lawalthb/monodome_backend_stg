<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeightPriceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'range' => $this->min_weight."kg to ".$this->max_weight."kg",
            'min_weight' => $this->min_weight,
            'max_weight' => $this->max_weight,
            'load_type_id' => $this->load_type_id,
            'price' => $this->price,
            'vehicle_description' => $this->vehicle_description,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
