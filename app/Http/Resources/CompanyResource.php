<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
           'email' => $this->user->email,
            'company_name' => $this->user->company_name,
          'street' => $this->street,
          'phone_number' => $this->phone_number,
          'number_of_drivers' => $this->number_of_drivers,
          'number_of_trucks' => $this->number_of_trucks,
          'trucks' => $this->trucks,
          "lga" => new LocalGovernmentResource($this->SLga),
          'company_logo' =>  getImageFile($this->company_logo),
          'status' => $this->status,
          'created_at' => $this->created_at,
          'updated_at' => $this->updated_at,
          'user' => new UserResource($this->user),
          'state' => new StateResource($this->state),
        ];
    }
}
