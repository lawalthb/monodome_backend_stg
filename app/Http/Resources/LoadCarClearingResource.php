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
            "car_value" => $this->car_value,
            "car_year" => $this->car_year,
            "comment" => $this->comment,
            "is_final" => $this->is_final,
            "car_type" => new VehicleTypeResource($this->carType),
            "car_model" => new VehicleModelResource($this->carModel),
            "deliver_from_city" => $this->DFromCity->name,//new CityResource($this->DFromCity),
            "deliver_to_city" => $this->DToCity->name, //new CityResource($this->deliver_to_city),
            "load_type_id" => new LoadTypeResource($this->loadType),
            "document" => LoadDocumentResource::collection($this->loadDocuments),
            "receiver_name" => $this->receiver_name,
            "receiver_email" => $this->receiver_email,
            "receiver_phone" => $this->receiver_phone,
            "status" => $this->status,

            "deliver_apartment" => $this->deliver_apartment,
        ];
    }
}
