<?php

namespace App\Http\Resources;

use App\Models\LoadBulk;
use App\Models\LoadPackage;
use Illuminate\Http\Request;
use App\Models\LoadContainer;
use App\Models\LoadSpecialized;
use App\Http\Resources\LoadContainerResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoadBoardResource extends JsonResource
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
            "load_type_name" => $this->load_type_name,
            "order_no" => $this->order_no,
            "load_date" => $this->load_date,
            "package" => $this->loadableResource(),
            "user" => new UserResource($this->user),
            "status" => $this->status,
        ];
    }


    // Define a method to return the appropriate resource based on the loadable model
protected function loadableResource()
{
    if ($this->loadable instanceof LoadPackage) {
        return new LoadPackageResource($this->loadable);

    } elseif ($this->loadable instanceof LoadSpecialized) {
        return new LoadSpecializedResource($this->loadable);

    } elseif ($this->loadable instanceof LoadCarClearingResource) {
        return new LoadCarClearingResource($this->loadable);

    }elseif ($this->loadable instanceof LoadBulk) {
        return new LoadBulkResource($this->loadable);

    } elseif ($this->loadable instanceof LoadContainer) {
        return new LoadContainerResource($this->loadable);
    }

    return null; // Handle other cases or return null if loadable is not recognized
}




}
