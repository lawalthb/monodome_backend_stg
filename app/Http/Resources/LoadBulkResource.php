<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadBulkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'uuid'=>$this->uuid,
            'load_type_id'=>$this->load_type_id,
            'load_type_name'=>$this->load_type_name,
            'deliver_from'=>$this->deliver_from,
            'to_office_id'=>$this->to_office_id,
            'sender_name'=>$this->sender_name,
            'sender_phone'=>$this->sender_phone,
            'sender_street'=>$this->sender_street_no,
            'sender_lga'=>new LocalGovernmentResource($this->SLga),
            "sender_state" => new StateResource($this->SState),
            'sender_apartment'=>$this->sender_apartment,
            'sender_email'=>$this->sender_email,
            'deliver_to'=>$this->deliver_to,
            //'from_office_id'=>$this->from_office_id,
            'receiver_name'=>$this->receiver_name,
            'receiver_phone'=>$this->receiver_phone,
            'receiver_lga'=> new LocalGovernmentResource($this->RLga),
            'receiver_street'=>$this->receiver_street,
            'receiver_apartment'=>$this->receiver_apartment,
            "receiver_state" => new StateResource($this->RState),
            'receiver_email'=>$this->receiver_email,
            'is_schedule'=>$this->is_schedule,
            'description'=>$this->description,
            'vehicle_no'=>$this->vehicle_no,
            'weight'=>$this->weight,
            'schedule_date'=>$this->schedule_date,
            'width'=>$this->width,
            'length'=>$this->length,
            'height'=>$this->height,
            'insure_it'=>$this->insure_it,
            'insure_amount'=>$this->insure_amount,
            'is_fragile'=>$this->is_fragile,
            "loadType" => new LoadTypeResource($this->loadType),
            "document" => LoadDocumentResource::collection($this->loadDocuments),
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
        ];
    }
}
