<?php

namespace App\Http\Controllers\Api\v1\Admin;

use Illuminate\Http\Request;
use App\Models\CarValuePrice;
use App\Models\CarCountryPrice;
use App\Http\Controllers\Controller;

class PriceController extends Controller
{


    public function allCarCountryPrice()
    {
        $prices = CarCountryPrice::all();
        return response()->json(['success' => true, 'data' => $prices]);
    }

    public function CarCountryPriceStore(Request $request)
    {
        $request->validate([
            'country' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);

        $price = CarCountryPrice::create([
            'country' => $request->input('country'),
            'price' => $request->input('price'),
            'status' => $request->input('status')
        ]);

        return response()->json(['success' => true, 'data' => $price]);
    }

    public function CarCountryPriceShow($id)
    {
        $price = CarCountryPrice::find($id);
        if (!$price) {
            return response()->json(['success' => false, 'message' => 'Price not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $price]);
    }

    public function CarCountryPriceUpdate(Request $request, $id)
    {
        $request->validate([
            'country' => 'string',
            'price' => 'numeric',
            'status' => 'in:active,inactive'
        ]);

        $price = CarCountryPrice::find($id);
        if (!$price) {
            return response()->json(['success' => false, 'message' => 'Price not found'], 404);
        }

        $price->country = $request->input('country', $price->country);
        $price->price = $request->input('price', $price->price);
        $price->status = $request->input('status', $price->status);
        $price->save();

        return response()->json(['success' => true, 'data' => $price]);
    }

    public function CarCountryPriceDestroy($id)
    {
        $price = CarCountryPrice::find($id);
        if (!$price) {
            return response()->json(['success' => false, 'message' => 'Price not found'], 404);
        }

        $price->delete();

        return response()->json(['success' => true, 'message' => 'Price deleted successfully']);
    }



    // everything below is for car value

    public function index()
    {
        $prices = CarValuePrice::all();
        return response()->json(['success' => true, 'data' => $prices]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'min' => 'required|numeric',
            'max' => 'required|numeric',
            'price' => 'required|numeric',
            'status' => 'required|in:active,inactive'
        ]);

        $price = CarValuePrice::create([
            'min' => $request->input('min'),
            'max' => $request->input('max'),
            'price' => $request->input('price'),
            'status' => $request->input('status')
        ]);

        return response()->json(['success' => true, 'data' => $price]);
    }

    public function show($id)
    {
        $price = CarValuePrice::find($id);
        if (!$price) {
            return response()->json(['success' => false, 'message' => 'Price not found'], 404);
        }
        return response()->json(['success' => true, 'data' => $price]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'min' => 'numeric',
            'max' => 'numeric',
            'price' => 'numeric',
            'status' => 'in:active,inactive'
        ]);

        $price = CarValuePrice::find($id);
        if (!$price) {
            return response()->json(['success' => false, 'message' => 'Price not found'], 404);
        }

        $price->min = $request->input('min', $price->min);
        $price->max = $request->input('max', $price->max);
        $price->price = $request->input('price', $price->price);
        $price->status = $request->input('status', $price->status);
        $price->save();

        return response()->json(['success' => true, 'data' => $price]);
    }

    public function destroy($id)
    {
        $price = CarValuePrice::find($id);
        if (!$price) {
            return response()->json(['success' => false, 'message' => 'Price not found'], 404);
        }

        $price->delete();

        return response()->json(['success' => true, 'message' => 'Price deleted successfully']);
    }
}
