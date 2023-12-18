<?php

namespace App\Http\Resources;

use App\Models\Driver;
use App\Models\LoadBulk;
use App\Models\LoadPackage;
use Illuminate\Http\Request;
use App\Models\LoadContainer;
use App\Models\LoadCarClearing;
use App\Models\LoadSpecialized;
use App\Http\Resources\LoadBulkResource;
use App\Http\Resources\LoadContainerResource;
use App\Models\Agent;
use App\Models\Company;
use App\Models\DriverManger;
use App\Models\ShippingCompany;
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
            "status" => $this->status,
            "accept_user" => $this->acceptableResource(),
            "package" => $this->loadableResource(),
            "user" => new UserResource($this->user),
        ];
    }


    // Define a method to return the appropriate resource based on the loadable model
protected function loadableResource()
{
    if ($this->loadable instanceof LoadPackage) {
        return new LoadPackageResource($this->loadable);

    } elseif ($this->loadable instanceof LoadSpecialized) {
        return new LoadSpecializedResource($this->loadable);

    } elseif ($this->loadable instanceof LoadCarClearing) {
        return new LoadCarClearingResource($this->loadable);

    }elseif ($this->loadable instanceof LoadBulk) {
        return new LoadBulkResource($this->loadable);

    } elseif ($this->loadable instanceof LoadContainer) {
        return new LoadContainerResource($this->loadable);
    }

    return null; // Handle other cases or return null if loadable is not recognized
}


protected function acceptableResource()
{
    if ($this->acceptable instanceof Driver) {
        return new DriverResource($this->acceptable);

    } elseif ($this->acceptable instanceof DriverManger) {
        return new DriverMangerResource($this->acceptable);

    } elseif ($this->acceptable instanceof Company) {
        return new CompanyResource($this->acceptable);

    }elseif ($this->acceptable instanceof Agent) {
        return new AgentResource($this->acceptable);

    } elseif ($this->acceptable instanceof ShippingCompany) {
        return new ShippingCompanyResource($this->acceptable);
    }

    return null; // Handle other cases or return null if acceptable is not recognized
}





}
