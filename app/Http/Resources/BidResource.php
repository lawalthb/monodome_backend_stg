<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BidResource extends JsonResource
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
            'amount' => $this->amount,
            'order' => new OrderResource($this->order),
            'driver' => new DriverResource( $this->driver),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
