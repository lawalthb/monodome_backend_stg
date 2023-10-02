<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingCompanyResource extends JsonResource
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
            'company_name' => $this->company_name,
            'email' => $this->user->email,
           'street' => $this->street,
           'phone_number' => $this->phone_number,
           "lga" => new LocalGovernmentResource($this->SLga),
           'profile_picture' =>  getImageFile($this->profile_picture),
           'status' => $this->status,
           'created_at' => $this->created_at,
           'updated_at' => $this->updated_at,
           'guarantors' => GuarantorResource::collection($this->guarantors),
           'user' => new UserResource($this->user),
           'state' => new StateResource($this->state),
        ];
    }
}
