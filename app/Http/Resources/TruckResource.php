<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TruckResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'phone_number' => $this->phone_number,
            'street' => $this->street,
            'truck_name' => $this->truck_name,
            'truck_type' => $this->truck_type,
            'truck_location' => $this->truck_location,
            'truck_make' => $this->truck_make,
            'plate_number' => $this->plate_number,
            'cac_number' => $this->cac_number,
            'truck_description' => $this->truck_description,
            'profile_picture' =>  getImageFile($this->profile_picture),
            "document" => LoadDocumentResource::collection($this->loadDocuments),
            'user' => new UserResource($this->user),
            'driver' => new DriverResource($this->driver),
            // ($this->whenLoaded('trucks')
            'lga' => new LocalGovernmentResource($this->local),
            'state' => new StateResource($this->state),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
