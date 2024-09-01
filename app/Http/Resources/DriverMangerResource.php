<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverMangerResource extends JsonResource
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
          'cac_certificate' =>  getImageFile($this->cac_certificate),
          'inside_office_image' => getImageFile($this->inside_office_image),
          'inside_store_image' => getImageFile($this->inside_store_image),
            'profile_picture' => getImageFile($this->profile_picture),
          'status' => $this->status,
          'total_user_manage' => $this->user_created_by->count(),
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'lga' => new LocalGovernmentResource($this->local),
          'state' => new StateResource($this->state),
          'user' => new UserResource($this->user),
          'guarantors' => GuarantorResource::collection($this->guarantors),
         // 'state_of_residence' => new StateResource($this->state_of_residence),
        ];
    }
}
