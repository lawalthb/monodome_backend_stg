<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GuarantorResource extends JsonResource
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
            'full_name' => $this->full_name,
            'phone_number' => $this->phone_number,
            'email' => $this->email,
            'street' => $this->street,
          //  'state' => $this->state,
            //'lga' => $this->lga,
            'lga' => new LocalGovernmentResource($this->LocalLga),
            'state' => new StateResource($this->LocalState),
            'profile_picture' =>  getImageFile($this->profile_picture),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
