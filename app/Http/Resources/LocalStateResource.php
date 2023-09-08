<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LocalStateResource extends JsonResource
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
            'name' => $this->name,
            'country_code' => $this->country_code,
           // 'fips_code' => $this->fips_code,
            'iso2' => $this->iso2,
            // 'latitude' => $this->latitude,
            // 'longitude' => $this->longitude,
            // 'flag' => (bool)$this->flag,
            // 'wikiDataId' => $this->wikiDataId,
            'country' => new CountryResource($this->country), // You can include the country details if you have a relationship
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];;
    }
}
