<?php

namespace App\Http\Controllers;

use App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return Tracking::all();
    }

    public function show($id)
    {
        return Tracking::findOrFail($id);
    }

    public function store(Request $request)
    {
        $tracking = Tracking::create($request->all());

        return response()->json($tracking, 201);
    }

    public function update(Request $request, $id)
    {
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
