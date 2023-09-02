<?php

namespace App\Http\Controllers\api\v1\customers;

use App\Models\VehicleMake;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleMakeRequest;

class VehicleMakeController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {
        $key = request()->input('search');

        $makes = VehicleMake::where(function ($q) use ($key) {
            $q->where('name', 'like', "%{$key}%")
            ->orWhere('name', 'like', "%{$key}%");
        })->latest()->paginate();

        return response()->json(['makes' => $makes]);
    }

    public function show($id)
    {
        $make = VehicleMake::with('models')->find($id);
        if (!$make) {
            return response()->json(['message' => 'Make not found'], 404);
        }
        return response()->json(['make' => $make]);
    }

    public function store(VehicleMakeRequest $request)
    {
        $make = VehicleMake::create($request->validated());
        return response()->json(['make' => $make], 201);
    }

    public function update(VehicleMakeRequest $request, $id)
    {
        $make = VehicleMake::find($id);
        if (!$make) {
            return response()->json(['message' => 'Make not found'], 404);
        }

        $make->update($request->validated());
        return response()->json(['make' => $make]);
    }

    public function destroy($id)
    {
        $make = VehicleMake::find($id);
        if (!$make) {
            return response()->json(['message' => 'Make not found'], 404);
        }

        $make->delete();
        return response()->json(['message' => 'Make deleted']);
    }
}
