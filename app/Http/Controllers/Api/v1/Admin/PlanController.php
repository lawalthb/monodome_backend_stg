<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {
        $key = request()->input('search');
        $perPage = request()->input('per_page', 10);

        $plan  = Plan::latest()->paginate($perPage);
        return  PlanResource::collection($plan);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'price' => 'required|numeric',
            'expired' => 'required|numeric',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        // Create the plan with validated data
        $plan = Plan::create($validator->validated());

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $this->saveImage('plan', $request->file('image'), 500, 500);
            $plan->update(['imageUrl' => $imagePath]);
        }

        return response()->json(['message' => 'Plan created successfully', 'data' => $plan], 201);
    }

    public function show(Plan $plan)
    {
        return response()->json($plan);
    }

    public function getTotal(Plan $plan)
    {
        // Count the users that have the given plan_id
        $totalUsers = User::where('plan_id', $plan->id)->count();

        return response()->json(['message' => 'Total users on this plan', 'amount' => $totalUsers], 200);
    }

    public function status(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $plan->status = $request->status;
        $plan->save();

        return response()->json(['message' => 'Status updated successfully', 'data' => $plan], 200);
    }

    public function update(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'expired' => 'required|numeric',
            'status' => 'nullable|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $plan->update($validator->validated());

        // Handle image upload if provided
        if ($request->hasFile('image')) {
            $imagePath = $this->saveImage('plan', $request->file('image'), 500, 500);
            $plan->update(['imageUrl' => $imagePath]);
        }

        return response()->json(['message' => 'Plan updated successfully', 'data' => $plan], 200);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json(['message' => 'Plan deleted successfully'], 200);
    }
}
