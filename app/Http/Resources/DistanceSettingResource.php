<?php

namespace App\Http\Resources;

use App\Models\PriceSetting;
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
            "from" => $this->from."km",
            "to" => $this->to."km",
            "price" => $this->price,
            "priceType" => $this->loadableResource(),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }


    protected function loadableResource()
{
    if ($this->loadable instanceof PriceSetting) {
        return new PriceSettingResource($this->loadable);
    }
    return null; // Handle other cases or return null if loadable is not recognized
}
}
