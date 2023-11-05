<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\VehicleMake;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleMakeRequest;
use App\Http\Resources\VehicleMakeResource;

class VehicleMakeController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {
        $key = request()->input('search');

        $makes = VehicleMake::where(function ($q) use ($key) {
            $q->where('name', 'like', "%{$key}%")
            ->orWhere('code', 'like', "%{$key}%");
        })->latest()->get();

        //
        return VehicleMakeResource::collection($makes);
    }

    public function show($id)
    {
        $make = VehicleMake::with('models')->find($id);
        if (!$make) {
            return response()->json(['message' => 'Make not found'], 404);
        }

        return $this->success(
            [
                "make" => new VehicleMakeResource($make),
            ],
            "Successfully"
        );

    }

    public function store(VehicleMakeRequest $request)
    {

        $validatedData = $request->validated();
        $validatedData['logo'] = $validatedData['logo'] ? $this->saveImage('vehicle', $validatedData['logo'], 60, 60) :   null;

        $make = VehicleMake::create($validatedData);

        return $this->success(
            [
                "make" => new VehicleMakeResource($make),
            ],
            "Created Successfully"
        );
    }

    public function update(VehicleMakeRequest $request, $id)
    {
        $make = VehicleMake::find($id);
        if (!$make) {
            return $this->error(null, "Vehicle Make not found",404 );

        }

        $make->update($request->validated());
        return $this->success(
            [
                "make" => new VehicleMakeResource($make),
            ],
            "update Successfully"
        );
    }

    public function destroy($id)
    {
        $make = VehicleMake::find($id);
        if (!$make) {
            return $this->error(null, "Vehicle Make not found",404 );
        }

        $make->delete();
        return $this->success(
           null,
            "deleted Successfully"
        );
    }
}
