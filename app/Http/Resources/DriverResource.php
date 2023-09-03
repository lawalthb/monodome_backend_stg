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
           // 'country' => new CountryResource($this->country),
          // 'city_of_residence' => new CityResource($this->city_of_residence),
          // 'state_of_residence' =>  new StateResource($this->state_of_residence),
          'street' => $this->street,
          'lga' => $this->lga,
          'registration_documents' =>  getImageFile($this->registration_documents),
          'store_front_image' => getImageFile($this->store_front_image),
          'inside_store_image' => getImageFile($this->inside_store_image),
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
