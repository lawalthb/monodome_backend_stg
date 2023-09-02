<?php

namespace App\Http\Controllers\api\v1\customers;

use App\Models\VehicleType;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleTypeRequest;
use App\Http\Resources\VehicleTypeResource;

class VehicleTypeController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {
          $key = request()->input('search');

        $types = VehicleType::where(function ($q) use ($key) {
            $q->where('name', 'like', "%{$key}%");
        })->latest()->paginate();

        //
        return VehicleTypeResource::collection($types);
    }

    public function store(VehicleTypeRequest $request)
    {
        $type = VehicleType::create($request->validated());

        return $this->success(
            [
                "type" => new VehicleTypeResource($type),
            ],
            "Created Successfully"
        );
    }

    public function show($id)
    {
        $type = VehicleType::findOrFail($id);

        if (!$type) {
            return response()->json(['message' => 'Make not found'], 404);
        }

        return $this->success(
            [
                "type" => new VehicleTypeResource($type),
            ],
            "Successfully"
        );

    }

    public function update(VehicleTypeRequest $request, $id)
    {
        $type = VehicleType::findOrFail($id);
        $type->update($request->validated());
        return response()->json(['data' => $type]);
    }

    public function destroy($id)
    {
        $type = VehicleType::findOrFail($id);
        if (!$type->delete()) {
            return $this->error(null, "Vehicle type not found", 404);
        }

        return $this->success(
            null,
            "Vehicle type  deleted successfully"
        );
    }
}
