<?php

namespace App\Http\Resources;

use App\Models\LoadBulk;
use App\Models\LoadPackage;
use Illuminate\Http\Request;
use App\Models\LoadContainer;
use App\Models\LoadSpecialized;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            "id" =>  $this->id,
            "uuid" =>  $this->uuid,
            "order_no" =>  $this->order_no,
            "amount" =>  $this->amount,
            "fee" =>  $this->fee,
            "total_amount" =>  $this->fee +$this->amount,
            "status" =>  $this->status,
            "updated_at" =>  $this->updated_at,
            "created_at" =>  $this->created_at,
            "user" =>  new UserResource($this->user),
            "package" => $this->loadableResource(),
        ];
    }


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
