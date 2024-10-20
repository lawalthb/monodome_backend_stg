<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\StateResource;
use App\Http\Resources\LocalStateResource;
use App\Http\Resources\LocalGovernmentResource;
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
            'width'=>$this->width,
            'length'=>$this->length,
            'height'=>$this->height,
            "inLoadBoard" => $this->isLoadTypeLoadable(),
            "loadBoard" => $this->loadBoard,
            'insure_it'=>$this->insure_it,
            'insure_amount'=>$this->insure_amount,
            "total_amount" => $this->total_amount,
            "delivery_fee" => $this->delivery_fee,
            "order" => $this->order,
            "driver" => $this->order->driver ?? null,
            'is_fragile'=>$this->is_fragile,
            'sender_location'=>$this->sender_location,
            'receiver_location'=>$this->receiver_location,
            'distance'=>$this->distance,
            'sender_name'=>$this->sender_name,
            'sender_phone'=>$this->sender_phone,
            'sender_street'=>$this->sender_street,
            'sender_lga'=>new LocalGovernmentResource($this->SLga),
            "sender_state" => new LocalStateResource($this->SState),
            'sender_apartment'=>$this->sender_apartment,
            'sender_apartment_no'=>$this->sender_apartment_no,
            'sender_email'=>$this->sender_email,
            'deliver_to' =>   ($this->deliver_to == "office") ? new AgentResource($this->officeTo) :  null,            // "from_office_id" => $this->from_office_id,load
            'deliver_from' =>($this->deliver_from == "office") ? new AgentResource($this->officeFrom) :  null,            // "from_office_id" => $this->from_office_id,load
            'receiver_name'=>$this->receiver_name,
            'receiver_phone'=>$this->receiver_phone,
            'receiver_lga'=> new LocalGovernmentResource($this->RLga),
            'receiver_street'=>$this->receiver_street,
            'receiver_apartment'=>$this->receiver_apartment,
            'receiver_apartment_no'=>$this->receiver_apartment_no,
            "receiver_state" => new LocalStateResource($this->RState),
            'receiver_email'=>$this->receiver_email,
            'is_schedule'=>$this->is_schedule,
            'description'=>$this->description,
            'vehicle_no'=>$this->vehicle_no,
            'weight'=>$this->weight,
            'is_private'=>$this->is_private,
            'schedule_date'=>$this->schedule_date,
            "acceptable" => $this->loadBoard && $this->loadBoard->acceptable ? new UserResource($this->loadBoard->acceptable) : null,
            "status" => $this->status,
            "loadType" => new LoadTypeResource($this->loadType),
            "document" => LoadDocumentResource::collection($this->loadDocuments),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
