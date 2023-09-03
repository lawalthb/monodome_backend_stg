<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
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
            'iso3' => $this->iso3,
            'iso2' => $this->iso2,
            'phonecode' => $this->phonecode,
            'capital' => $this->capital,
            'currency' => $this->currency,
            'currency_symbol' => $this->currency_symbol,
            // 'tld' => $this->tld,
            // 'native' => $this->native,
            // 'region' => $this->region,
            // 'subregion' => $this->subregion,
            // 'timezones' => json_decode($this->timezones),
            // 'translations' => json_decode($this->translations),
            // 'latitude' => $this->latitude,
            // 'longitude' => $this->longitude,
            // 'emoji' => $this->emoji,
            // 'emojiU' => $this->emojiU,
            // 'flag' => (bool)$this->flag,
            // 'wikiDataId' => $this->wikiDataId,
            // 'created_at' => $this->created_at,
            // 'updated_at' => $this->updated_at,
        ];
    }
}
