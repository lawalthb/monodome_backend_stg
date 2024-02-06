<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\WeightPrice;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\WeightPriceRequest;
use App\Http\Resources\WeightPriceResource;

class WeightPriceController extends Controller
{
    public function index()
    {
        $weightPrices = WeightPrice::all();
        return WeightPriceResource::collection($weightPrices);
    }

    public function show($id)
    {
        $weightPrice = WeightPrice::findOrFail($id);
        return new WeightPriceResource($weightPrice);
    }

    public function store(WeightPriceRequest $request)
    {
        $weightPrice = WeightPrice::create($request->validated());
        return new WeightPriceResource($weightPrice);
    }

    public function update(WeightPriceRequest $request, $id)
    {
        $weightPrice = WeightPrice::findOrFail($id);
        $weightPrice->update($request->validated());
        return new WeightPriceResource($weightPrice);
    }

    public function destroy($id)
    {
        $weightPrice = WeightPrice::findOrFail($id);
        $weightPrice->delete();

        return response()->json(['message' => 'Weight price deleted successfully']);
    }

    public function getWeightPricesByLoadType(int $id){

        $weightPrice = WeightPrice::where("load_type_id",$id)->get();

        return WeightPriceResource::collection($weightPrice);
    }


    public function getWeightPriceIDByLoadType(int $id, int $load_type_id){

        $weightPrice = WeightPrice::where("load_type_id",$load_type_id)->where("id",$id)->first();

        return new WeightPriceResource($weightPrice);

    }


}
