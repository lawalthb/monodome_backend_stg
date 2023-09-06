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
            "uuid" => $this->uuid,
            "deliver_from" => $this->deliver_from,
            'office' => ($this->deliver_from =="office") ? new AgentResource($this->office) :  null,
            "sender_name" => $this->sender_name,
            "sender_phone" => $this->sender_phone,
            "sender_apartment" => $this->sender_apartment,
            "sender_apartment_no" => $this->sender_apartment_no,
            "sender_lga" => new LocalGovernmentResource($this->SLga),
            "sender_street" => $this->sender_street,
          "sender_state" => new StateResource($this->SState),
            "sender_email" => $this->sender_email,
            "deliver_to" => $this->deliver_to,
           // "from_office_id" => $this->from_office_id,load
           "receiver_name" => $this->receiver_name,
           "receiver_email" => $this->receiver_email,
            "receiver_phone" => $this->receiver_phone,
            "receiver_apartment" => $this->receiver_apartment,
            "receiver_apartment_no" => $this->receiver_apartment_no,
           "receiver_state" => new StateResource($this->RState),
            "receiver_street" => $this->receiver_street,
            "receiver_lga" => new LocalGovernmentResource($this->RLga),
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
