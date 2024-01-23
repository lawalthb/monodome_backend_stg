<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DistancePrice;
use App\Http\Requests\DistancePriceRequest;
use App\Http\Resources\DistancePriceResource;

class DistancePriceController extends Controller
{
    public function index()
    {
        $distancePrices = DistancePrice::all();
        return DistancePriceResource::collection($distancePrices);
    }

    public function show($id)
    {
        $distancePrice = DistancePrice::findOrFail($id);
        return new DistancePriceResource($distancePrice);
    }

    public function store(DistancePriceRequest $request)
    {
        $distancePrice = DistancePrice::create($request->validated());
        return new DistancePriceResource($distancePrice);
    }

    public function update(DistancePriceRequest $request, $id)
    {
        $distancePrice = DistancePrice::findOrFail($id);
        $distancePrice->update($request->validated());
        return new DistancePriceResource($distancePrice);
    }

    public function destroy($id)
    {
        $distancePrice = DistancePrice::findOrFail($id);
        $distancePrice->delete();

        return response()->json(['message' => 'Distance price deleted successfully']);
    }
}
