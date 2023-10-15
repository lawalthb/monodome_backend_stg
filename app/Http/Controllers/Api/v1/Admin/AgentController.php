<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;

class AgentController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $agents = Agent::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%")->orWhere('business_name', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return AgentResource::collection($agents);
    }


    public function search(Request $request)
    {
        $terms = explode(" ", $request->input('search'));
        $perPage = $request->input('per_page', 10);

        $agents = Agent::query();

        foreach ($terms as $term) {
            $agents->where(function ($query) use ($term) {
                $query->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('email', 'like', "%$term%")
                        ->orWhere('full_name', 'like', "%$term%");
                })
                ->orWhere('street', 'like', "%$term%")
                ->orWhere('business_name', 'like', "%$term%")
                ->orWhere('status', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            });
        }

        $agents = $agents->latest()->paginate($perPage);

        return AgentResource::collection($agents);
    }

    public function show($agentId) {
        $agent = Agent::find($agentId);

        if (!$agent) {
            return response()->json(['message' => 'Agent not found'], 404);
        }

        return new AgentResource($agent);
    }

    public function destroy($userId) {
        // Find the user by ID
        $user = User::find($userId);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $agent = $user->agent;
        if ($agent) {
            $agent->delete();
        }

        $user->delete();

        return response()->json(['message' => 'User deleted successfully']);
    }


    public function setStatus($agentId, $newStatus) {
        // Find the agent by ID
        $agent = Agent::find($agentId);

        if (!$agent) {
            return response()->json(['message' => 'Agent not found'], 404);
        }

        // Update the status
        $agent->status = $newStatus;
        $agent->save();

        return response()->json(['message' => 'Agent status updated successfully', 'new_status' => $newStatus]);
    }


}
