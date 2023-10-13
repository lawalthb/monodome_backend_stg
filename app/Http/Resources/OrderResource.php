<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" =>  $this->id,
            "uuid" =>  $this->uuid,
            "order_no" =>  $this->order_no,
            "amount" =>  $this->amount,
            "user" =>  new UserResource($this->user),
            "status" =>  $this->status,
            "updated_at" =>  $this->updated_at,
            "created_at" =>  $this->created_at,
        ];
    }
}
