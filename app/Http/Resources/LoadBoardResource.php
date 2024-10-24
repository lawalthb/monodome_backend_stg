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
use App\Models\Truck;
use App\Models\User;
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
            "order" => new OrderResource($this->order),
            "accept_driver" => $this->acceptable,
            "accept_truck" => new TruckResource(Truck::where("driver_user_id",$this->acceptable_id)->whereNotNull('driver_user_id')->first()) ?? null,
            // "accept_user" => $this->acceptableResource(),
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
    if ($this->acceptable instanceof User) {
        return new UserRoleResource($this->acceptable);

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

// protected function acceptableResource()
// {
//     switch ($this->acceptable_type) {
//         case 'App\\Models\\Driver':
//             return new DriverResource($this->acceptable);
//         case 'App\\Models\\DriverManager':
//             return new DriverMangerResource($this->acceptable);
//         case 'App\\Models\\Company':
//             return new CompanyResource($this->acceptable);
//         case 'App\\Models\\Agent':
//             return new AgentResource($this->acceptable);
//         case 'App\\Models\\ShippingCompany':
//             return new ShippingCompanyResource($this->acceptable);
//         default:
//             return null;
//     }
// }





}
