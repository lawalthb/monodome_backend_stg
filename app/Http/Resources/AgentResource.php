<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\LocalGovernmentResource;
use Illuminate\Http\Resources\Json\JsonResource;

class AgentResource extends JsonResource
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
          'agent_code' => $this->agent_code,
           'name' => $this->user->full_name,
          'nin_number' => $this->nin_number,
          'street' => $this->street,
          'business_name' => $this->business_name,
         // 'phone_number' => $this->phone_number,
          'status' => $this->status,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'registration_documents' =>  getImageFile($this->registration_documents),
          'cac_certificate' =>  getImageFile($this->cac_certificate),
          'other_documents' =>  getImageFile($this->other_documents),
          'store_front_image' => getImageFile($this->store_front_image),
          'inside_store_image' => getImageFile($this->inside_store_image),
          'user' => new UserResource($this->user),
          'lga' => new LocalGovernmentResource($this->local),
          'state' => new StateResource($this->state),
          'guarantors' => GuarantorResource::collection($this->guarantors),
         // 'state_of_residence' => new StateResource($this->state_of_residence),
        ];
    }
}
