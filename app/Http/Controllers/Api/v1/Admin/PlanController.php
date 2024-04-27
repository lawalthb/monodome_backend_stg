<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Plan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    public function index()
    {
        return Plan::all();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'expired' => 'numeric|required',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $plan = Plan::create($request->all());
        return response()->json(['message' => 'Plan created successfully', 'data' => $plan], 201);
    }

    public function show(Plan $plan)
    {
        return $plan;
    }

    public function status(Request $request,Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $plan->status = $request->status;
        $plan->save();

        return $plan;
    }

    public function update(Request $request, Plan $plan)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'expired' => 'numeric|required',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $plan->update($request->all());
        return response()->json(['message' => 'Plan updated successfully', 'data' => $plan], 200);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json(['message' => 'Plan deleted successfully'], 200);
    }
}
