<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletHistoryResource extends JsonResource
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
            "uuid" => $this->uuid,
            "wallet_type" => $this->wallet_type,
            "payment_type" => $this->payment_type,
            "reference" => $this->paystack_reference,
            "description" => $this->description,
            "fee" => $this->fee,
            "amount" => $this->amount,
            "closing_balance" => $this->wallet->amount,
            "user" => new UserResource($this->user),
            "wallet" => new WalletResource($this->wallet),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,

        ];
    }
}
