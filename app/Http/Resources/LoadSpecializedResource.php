<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadSpecializedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" =>  $this->id,
            "uuid" =>  $this->uuid,
            "order" => $this->order,
            "inLoadBoard" => $this->isLoadTypeLoadable(),
            'sender_location'=>$this->sender_location,
            'receiver_location'=>$this->receiver_location,
            'distance'=>$this->distance,
            "sender_email" =>  $this->sender_email,
            "sender_name" =>  $this->sender_name,
            "sender_phone" =>  $this->sender_phone,
            "receiver_name" =>  $this->receiver_name,
            "receiver_email" =>  $this->receiver_email,
            "receiver_phone" =>  $this->receiver_phone,
            "total_amount" =>  $this->total_amount,
            "description" =>  $this->description,
            "document" => LoadDocumentResource::collection($this->loadDocuments),
            "user" =>  new UserResource($this->user),
            "loadType" => new LoadTypeResource($this->loadType),
            "deliver_from_country" =>  new CountryResource($this->DepCountry),
            "deliver_from_state" =>  new StateResource($this->SState),
            "deliver_to_country" =>  new CountryResource($this->DesCountry),
            "deliver_to_state" =>  new StateResource($this->RState),
            "created_at" =>  $this->created_at,
            "updated_at" =>  $this->updated_at,
        ];
    }
}
