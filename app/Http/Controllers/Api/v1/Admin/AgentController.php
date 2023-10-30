<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Agent;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\AgentResource;
use Illuminate\Support\Facades\Validator;

class AgentController extends Controller
{

    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
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
                ->orWhere('agent_code', 'like', "%$term%")
                ->orWhere('business_name', 'like', "%$term%")
                ->orWhere('agent_code', 'like', "%$term%")
                ->orWhere('status', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            });
        }

        $agents = $agents->latest()->paginate($perPage);

        return AgentResource::collection($agents);



        // $key = $request->input('search');
        // $perPage = $request->input('per_page', 10);

        // $agents = Agent::where(function ($q) use ($key) {
        //     // Assuming there's a relationship between Agent and User
        //     $q->whereHas('user', function ($userQuery) use ($key) {
        //         $userQuery->where('full_name', 'like', "%{$key}%");
        //     })->orWhere('status', 'like', "%{$key}%")
        //     ->orWhere('agent_code', 'like', "%{$key}%")
        //     ->orWhere('nin_number', 'like', "%{$key}%")
        //     ->orWhere('business_name', 'like', "%{$key}%");
        // })
        //     ->latest()
        //     ->paginate($perPage);

        // return AgentResource::collection($agents);
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
                ->orWhere('phone_number', 'like', "%$term%")
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

            return $this->error('', 'Agent not found', 422);

        }

        return new AgentResource($agent);
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $agent = Agent::findOrFail($id);

            // Update agent information
            $agent->phone_number = $request->input('phone_number');
            $agent->street = $request->input('address');
            $agent->save();

            // Update agent information
            if ($agent->user) {
                // If the user has an associated agent, update its information
            $user = $agent->user;
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $user->phone_number = $request->input('phone_number');
            $user->save();

            }

            DB::commit();

            return $this->success(new AgentResource($user->agent), 'Agent updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while updating the agent and user.');
        }
    }


    public function destroy($agentId)
    {
        try {
            // Find the agent by ID
            $agent = Agent::with('user')->find($agentId);

        if (!$agent) {
                return $this->error('', 'Agent not found', 404);
            }

            if ( $user = $agent->user) {
                $agent->delete();

                $user->delete();

            return $this->success([], 'Agent and user deleted successfully');

        }
        } catch (\Exception $e) {
            return $this->error('', 'Unable to delete Agent and user', 500);
        }
    }



    public function setStatus(Request $request, $agentId) {


        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Failed'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $agent = Agent::find($agentId);

        if (!$agent) {

            return $this->error('', 'Agent not found', 422);

        }

        // Update the status
        $agent->status = $request->status;
        $agent->save();

        return $this->success(['agent'=> new AgentResource($agent)], 'Agent status updated successfully');
    }


}
