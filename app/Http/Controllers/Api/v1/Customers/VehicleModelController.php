<?php

namespace App\Http\Controllers\Api\v1\customers;

use App\Models\VehicleModel;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleModelRequest;
use App\Http\Resources\VehicleModelResource;

class VehicleModelController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {
        $key = request()->input('search');

        $models = VehicleModel::where(function ($q) use ($key) {
            $q->where('name', 'like', "%{$key}%")
                ->orWhere('code', 'like', "%{$key}%");
        })->latest()->paginate();

        //
        return VehicleModelResource::collection($models);
    }

    public function store(VehicleModelRequest $request)
    {
        $model = VehicleModel::create($request->validated());

        return $this->success(
            [
                "model" => new VehicleModelResource($model),
            ],
            "Created Successfully"
        );
    }

    public function show($id)
    {
        $model = VehicleModel::with('make')->findOrFail($id);

        if (!$model) {
            return response()->json(['message' => 'Make not found'], 404);
        }

        return $this->success(
            [
                "model" => new VehicleModelResource($model),
            ],
            "Successfully"
        );
    }

    public function update(VehicleModelRequest $request, $id)
    {
        $model = VehicleModel::findOrFail($id);
        $model->update($request->validated());

        return $this->success(
            [
                "model" => new VehicleModelResource($model),
            ],
            "update Successfully"
        );
    }

    public function destroy($id)
    {
        $model = VehicleModel::findOrFail($id);

        if (!$model->delete()) {
            return $this->error(null, "Vehicle model not found", 404);
        }

        return $this->success(
            null,
            "Vehicle model deleted successfully"
        );
    }
}
