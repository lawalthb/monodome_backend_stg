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
            "order" => $this->order,
            'sender_location'=>$this->sender_location,
            'receiver_location'=>$this->receiver_location,
            'distance'=>$this->distance,
            "sender_name" => $this->sender_name,
            "sender_phone" => $this->sender_phone,
            "sender_apartment" => $this->sender_apartment,
            "sender_apartment_no" => $this->sender_apartment_no,
            "sender_street" => $this->sender_street,
            "sender_lga" => new LocalGovernmentResource($this->SLga),
            "sender_state" => new LocalStateResource($this->SState),
            "sender_email" => $this->sender_email,
            'office' => ($this->deliver_to == "office") ? new AgentResource($this->office) :  null,            // "from_office_id" => $this->from_office_id,load
            "receiver_name" => $this->receiver_name,
            "receiver_email" => $this->receiver_email,
            "receiver_phone" => $this->receiver_phone,
            "receiver_apartment" => $this->receiver_apartment,
            "receiver_apartment_no" => $this->receiver_apartment_no,
            "receiver_street" => $this->receiver_street,
            "receiver_lga" => new LocalGovernmentResource($this->RLga),
            "receiver_state" => new LocalStateResource($this->RState),
            "is_document" => $this->is_document,
            "description" => $this->description,
            "weight" => $this->weight,
            "width" => $this->width,
            "length" => $this->length,
            "height" => $this->height,
            "total_amount" => $this->total_amount,
            "status" => $this->status,
            "insure_it" => $this->insure_it,
            "insure_amount" => $this->insure_amount,
            "is_fragile" => $this->is_fragile,
            "loadType" => new LoadTypeResource($this->loadType),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
