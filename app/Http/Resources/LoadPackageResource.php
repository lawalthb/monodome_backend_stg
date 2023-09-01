<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\LoadTypeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadPackageResource extends JsonResource
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
            "deliver_from" => $this->deliver_from,
            "to_office_id" => $this->to_office_id,
            "sender_name" => $this->sender_name,
            "sender_phone" => $this->sender_phone,
            "sender_zipcode" => $this->sender_zipcode,
            "sender_city" => $this->sender_city,
            "sender_street" => $this->sender_street,
            "state_id" => $this->state_id,
            "sender_email" => $this->sender_email,
            "deliver_to" => $this->deliver_to,
            "from_office_id" => $this->from_office_id,
            "receiver_name" => $this->receiver_name,
            "receiver_phone" => $this->receiver_phone,
            "receiver_zipcode" => $this->receiver_zipcode,
            "receiver_city" => $this->receiver_city,
            "receiver_street" => $this->receiver_street,
            "receiver_number" => $this->receiver_number,
            "receiver_email" => $this->receiver_email,
            "is_document" => $this->is_document,
            "description" => $this->description,
            "weight" => $this->weight,
            "width" => $this->width,
            "length" => $this->length,
            "height" => $this->height,
            "insure_it" => $this->insure_it,
            "insure_amount" => $this->insure_amount,
            "is_fragile" => $this->is_fragile,
            "loadType" => new LoadTypeResource($this->loadType),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
