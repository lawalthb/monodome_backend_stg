<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
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
        'name' => $this->user->full_name,
          'have_motor' => $this->have_motor,
          'type' => $this->type,
          'nin_number' => $this->nin_number,
          'license_number' => $this->license_number,
          'street' => $this->street,
          'status' => $this->status,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'vehicleType' => new VehicleTypeResource($this->vehicleType),
          'registration_documents' =>  getImageFile($this->registration_documents),
          'proof_of_license' => getImageFile($this->proof_of_license),
          'profile_picture' => getImageFile($this->profile_picture),
          'user' => new UserResource($this->user),
          "vehicle_image" => LoadDocumentResource::collection($this->loadDocuments),
          "lga" => new LocalGovernmentResource($this->RLga),
          'guarantors' => GuarantorResource::collection($this->guarantors),
          'state' => new StateResource($this->state),
          'truck' => new TruckResource($this->truck),
        ];
    }
}
