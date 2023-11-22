<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadCarClearingResource extends JsonResource
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
            "order_no" => $this->order->order_no,
            'sender_location'=>$this->sender_location,
            'receiver_location'=>$this->receiver_location,
            'distance'=>$this->distance,
            "destination_country" => new CountryResource($this->DesCountry),
            "departure_country" => new CountryResource($this->DepCountry),
            "car_value" => $this->car_value,
            "car_year" => $this->car_year,
            "comment" => $this->comment,
            "is_final" => $this->is_final,
            "suggested_amount" => $this->suggested_amount,
            "car_type" => new VehicleTypeResource($this->carType),
            "car_model" => new VehicleModelResource($this->carModel),
            "deliver_from_city" => $this->DFromCity ? $this->DFromCity->name : null,
            "deliver_to_city" => $this->DToCity ? $this->DToCity->name : null,
            "load_type_id" => new LoadTypeResource($this->loadType),
            "document" => LoadDocumentResource::collection($this->loadDocuments),
            "receiver_name" => $this->receiver_name,
            "receiver_email" => $this->receiver_email,
            "receiver_phone" => $this->receiver_phone,
            "status" => $this->status,
            "total_amount" => $this->total_amount,
            "deliver_apartment" => $this->deliver_apartment,
        ];
    }
}
