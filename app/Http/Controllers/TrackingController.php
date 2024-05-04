<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return Tracking::with('order')->latest()->get();
    }

    public function show($id)
    {
        return Tracking::with('order')->where("order_no",$id)->orWhere("tracking_id",$id)->first();
    }
    public function store(Request $request)
    {
        $request->validate([
            'order_no' => 'required|string|unique:trackings',
            'comment' => 'nullable|string',
            'time' => 'nullable|date',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'location' => 'nullable|string',
            'driver_id' => 'required|exists:drivers,id',
            'status' => 'required|string',
        ]);

        $tracking = Tracking::create($request->all());

        return response()->json($tracking, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'order_no' => 'required','string',
            'comment' => 'nullable|string',
            'time' => 'nullable|date',
            'longitude' => 'nullable|string',
            'latitude' => 'nullable|string',
            'location' => 'nullable|string',
            'driver_id' => 'required|exists:drivers,id',
            'status' => 'required|string',
        ]);

        $tracking = Tracking::findOrFail($id);
        $tracking->update($request->all());

        return response()->json($tracking, 200);
    }
    public function destroy($id)
    {
        $tracking = Tracking::findOrFail($id);
        $tracking->delete();

        return response()->json(null, 204);
    }
}
