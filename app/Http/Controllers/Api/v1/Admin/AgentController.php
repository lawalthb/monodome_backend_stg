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
              //  ->orWhere('status', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            });
        }

        $agents = $agents->where('status','Confirmed')->latest()->paginate($perPage);

        return AgentResource::collection($agents);
    }


    public function pending(Request $request){

         $perPage = $request->input('per_page', 10);

        $agents = Agent::query();


        $agents = $agents->whereIn('status', ['Pending','Rejected'])->latest()->paginate($perPage);

        return AgentResource::collection($agents);
    }


    public function statusType(Request $request)
    {

        $terms = explode(" ", $request->input('search'));
        $perPage = $request->input('per_page', 10);
        $sort = $request->input('sort');
        $date_start = $request->input('date_start');
        $date_end = $request->input('date_end');

        // Create the query to retrieve agents with "Pending" or "Rejected" status
        $agents = Agent::where(function ($query) use ($terms) {
            $query->whereIn('status', $terms);

            foreach ($terms as $term) {
                $query->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('email', 'like', "%$term%")
                               ->orWhere('full_name', 'like', "%$term%");
                })
                ->orWhere('street', 'like', "%$term%")
                ->orWhere('business_name', 'like', "%$term%")
                ->orWhere('phone_number', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            }
        });

        // Retrieve the results and paginate them
        $agents = $agents->latest()->paginate($perPage);

        return AgentResource::collection($agents);
    }



    public function search(Request $request)
{
    // Get query parameters from the request
    $sort = $request->input('sort');
    $email = $request->input('email');
    $businessName = $request->input('business_name');
    $phone = $request->input('phone_number');
    $status = $request->input('status');
    $fullName = $request->input('full_name');
    $startDate = $request->input('start_date');
    $endDate = $request->input('end_date');
    $date = $request->input('date');

    // Apply filters to the Agent query
    $agents = Agent::query();

    // Filter by 'sort' parameter
    if ($sort) {
        $agents->orderBy($sort);
    }

    // Filter by 'email' parameter
    if ($email) {
        $agents->whereHas('user', function ($userQuery) use ($email) {
            $userQuery->where('email', 'like', "%$email%");
        });
    }

    // Filter by 'business_name' parameter
    if ($businessName) {
        $agents->where('business_name', 'like', "%$businessName%");
    }

    // Filter by 'phone_number' parameter
    if ($phone) {
        $agents->where('phone_number', 'like', "%$phone%");
    }

    // Filter by 'status' parameter
    if ($status) {
        $agents->where('status', $status);
    }

    // Filter by 'full_name' parameter
    if ($fullName) {
        $agents->whereHas('user', function ($userQuery) use ($fullName) {
            $userQuery->where('full_name', 'like', "%$fullName%");
        });
    }

    // Filter by date range
    if ($startDate) {
        $agents->whereDate('created_at', '>=', $startDate);
    }

    if ($date) {
        $agents->whereDate('created_at', '=', $date);
    }

    if ($endDate) {
        $agents->whereDate('created_at', '<=', $endDate);
    }

    $perPage = $request->input('per_page', 10);

    // Retrieve and paginate the results
    $agents = $agents->latest()->paginate($perPage);

    return AgentResource::collection($agents);
}



    // public function search(Request $request)
    // {
    //     $terms = explode(" ", $request->input('search'));

    //     $perPage = $request->input('per_page', 10);

    //     $agents = Agent::query();

    //     foreach ($terms as $term) {
    //         $terms1 = $terms[1];
    //         $agents->where(function ($query) use ($term) {
    //             $query->orWhereHas('user', function ($userQuery) use ($term) {
    //                 $userQuery->where('email', 'like', "%$term%")
    //                     ->orWhere('full_name', 'like', "%$term%");
    //             })
    //             ->orWhere('street', 'like', "%$term%")
    //             ->orWhere('business_name', 'like', "%$term%")
    //             ->orWhere('phone_number', 'like', "%$term%")
    //             ->orWhere('status', 'like', "%$term%")
    //             ->orWhere('status', 'like', "%$terms1%")
    //             ->orWhereHas('state', function ($stateQuery) use ($term) {
    //                 $stateQuery->where('name', 'like', "%$term%");
    //             });
    //         });
    //     }

    //     $agents = $agents->latest()->paginate($perPage);

    //     return AgentResource::collection($agents);
    // }

    public function show($agentId) {
        $agent = Agent::find($agentId);

        if (!$agent) {

            return $this->error('', 'Agent not found', 422);

        }

        return new AgentResource($agent);
    }


    public function update(Request $request, $id)
    {
        // try {
        //     DB::beginTransaction();

            $agent = Agent::find($id);

            // Update agent information
            $agent->phone_number = $request->input('phone_number');
            $agent->street = $request->input('address');
            $agent->business_name = $request->input('business_name');
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
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     Log::error($e->getMessage());

        //     return $this->error('An error occurred while updating the agent and user.');
        // }
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
