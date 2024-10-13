<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadContainerResource extends JsonResource
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
            "order" => $this->order,
            "inLoadBoard" => $this->isLoadTypeLoadable(),
            'sender_location'=>$this->sender_location,
            'receiver_location'=>$this->receiver_location,
            'distance'=>$this->distance,
            "destination_country" => new CountryResource($this->DesCountry),
            "departure_country" => new CountryResource($this->DepCountry),
            "container_height" => $this->container_height,
            "container_carrier" => $this->containerCarrier,//new ContainerCarrierResource($this->containerCarrier),
            "container_value" => $this->container_value,
            "cars_in_container" => json_decode($this->cars_in_container),
            "other_contents_in_container" => json_decode($this->other_contents_in_container),
            "content_description" => $this->content_description,
            "is_final" => $this->is_final,
            "suggested_amount" => $this->suggested_amount,
            "deliver_from_city" => $this->DFromCity ? $this->DFromCity->name : null,
            "deliver_to_city" => $this->DToCity ? $this->DToCity->name : null,
            "loadType" => new LoadTypeResource($this->loadType),
            "document" => LoadDocumentResource::collection($this->loadDocuments),
            "acceptable" => $this->loadBoard && $this->loadBoard->acceptable ? new UserResource($this->loadBoard->acceptable) : null,
            "receiver_name" => $this->receiver_name,
            "receiver_email" => $this->receiver_email,
            "receiver_phone" => $this->receiver_phone,
            "total_amount" => $this->total_amount,
            "status" => $this->status,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at,
        ];
    }
}
