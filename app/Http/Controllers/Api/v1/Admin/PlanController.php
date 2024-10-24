<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Exports\UsersByPlanExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Http\Resources\UserResource;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class PlanController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {
        $key = request()->input('search');
        $perPage = request()->input('per_page', 10);

        $plans = Plan::withCount('users')->latest()->paginate($perPage);
        return PlanResource::collection($plans);
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

        $plan = Plan::create($validator->validated());

        if ($request->hasFile('image')) {
            $imagePath = $this->saveImage('plan', $request->file('image'), 500, 500);
            $plan->update(['image' => $imagePath]);
        }

        return new PlanResource($plan);
    }

    public function show(Plan $plan)
    {
        return new PlanResource($plan);
    }


    public function getTotal()
    {
        $plans = Plan::withCount('users')->get();
        $totalUsers = User::count();

        $groupedUsers = DB::table('users')
            ->select('plan_id', DB::raw('count(*) as total'))
            ->groupBy('plan_id')
            ->get();

        $data = [
            'total_users' => $totalUsers,
            'plans' => PlanResource::collection($plans),
            'grouped_users' => $groupedUsers
        ];

        return response()->json(['message' => 'Total users and plans information', 'data' => $data], 200);
    }

    public function getTotalById($plan_id)
    {
        $plan = Plan::withCount('users')->findOrFail($plan_id);
        $totalUsers = User::where('plan_id', $plan_id)->count();

        $data = [
            'plan' => new PlanResource($plan),
            'total_users' => $totalUsers
        ];

        return response()->json(['message' => 'Total users for the plan', 'data' => $data], 200);
    }

    public function status(Request $request, Plan $plan)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:active,inactive',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()], 400);
        }

        $plan->update(['status' => $request->status]);

        return new PlanResource($plan);
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

        if ($request->hasFile('image')) {
            $imagePath = $this->saveImage('plan', $request->file('image'), 500, 500);
            $plan->update(['image' => $imagePath]);
        }

        return new PlanResource($plan);
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();
        return response()->json(['message' => 'Plan deleted successfully'], 200);
    }

    public function getUsersByPlan($plan_id, Request $request)
    {
        $plan = Plan::findOrFail($plan_id);

        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = $plan->users();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate($perPage);

        return response()->json([
            'message' => 'Users subscribed to the plan',
            'data' => UserResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ],
        ], 200);
    }

    public function getAllUsersWithPlans(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $search = $request->input('search');

        $query = User::with('plan');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone_number', 'like', "%{$search}%");
            });
        }

        $users = $query->paginate($perPage);

        return response()->json([
            'message' => 'All users with their plans',
            'data' => UserResource::collection($users),
            'meta' => [
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'per_page' => $users->perPage(),
                'total' => $users->total(),
            ],
        ], 200);
    }

    public function exportUsersByPlan($plan_id)
    {
        $plan = Plan::findOrFail($plan_id);
        return Excel::download(new UsersByPlanExport($plan_id), 'users_by_plan_' . $plan->name . '.xlsx');
    }
}
