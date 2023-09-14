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
        'name' => $this->user->full_name,
          'street' => $this->street,
          "lga" => new LocalGovernmentResource($this->RLga),
          //'registration_documents' =>  getImageFile($this->registration_documents),
          'proof_of_license' => getImageFile($this->proof_of_license),
          'profile_picture' => getImageFile($this->profile_picture),
          "vehicle_image" => LoadDocumentResource::collection($this->loadDocuments),
          'status' => $this->status,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'user' => new UserResource($this->user),
          'guarantors' => GuarantorResource::collection($this->guarantors),
          'state' => new StateResource($this->state),
         // 'state_of_residence' => new StateResource($this->state_of_residence),
        ];
    }
}
