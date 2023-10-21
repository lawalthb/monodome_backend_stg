<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Broker;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\BrokerResource;

class BrokerController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $brokers = Broker::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('status', 'like', "%{$key}%")->orWhere('nin_number', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return BrokerResource::collection($brokers);
    }


    public function search(Request $request)
    {
        $terms = explode(" ", $request->input('search'));
        $perPage = $request->input('per_page', 10);

        $brokers = Broker::query();

        foreach ($terms as $term) {
            $brokers->where(function ($query) use ($term) {
                $query->orWhereHas('user', function ($userQuery) use ($term) {
                    $userQuery->where('email', 'like', "%$term%")
                        ->orWhere('full_name', 'like', "%$term%");
                })
                ->orWhere('phone_number', 'like', "%$term%")
                ->orWhere('nin_number', 'like', "%$term%")
                ->orWhere('status', 'like', "%$term%")
                ->orWhereHas('state', function ($stateQuery) use ($term) {
                    $stateQuery->where('name', 'like', "%$term%");
                });
            });
        }

        $brokers = $brokers->latest()->paginate($perPage);

        return BrokerResource::collection($brokers);
    }

    public function show($brokerId) {
        $broker = Broker::find($brokerId);

        if (!$broker) {

            return $this->error('', 'Broker not found', 422);

        }

        return new BrokerResource($broker);
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $broker = Broker::findOrFail($id);

            // Update broker information
            $broker->phone_number = $request->input('phone_number');
            $broker->street = $request->input('address');
            $broker->save();

            // Update broker information
            if ($broker->user) {
                // If the user has an associated broker, update its information
            $user = $broker->user;
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $user->phone_number = $request->input('phone_number');
            $user->save();

            }

            DB::commit();

            return $this->success(new BrokerResource($user->broker), 'broker updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while updating the broker and user.');
        }
    }


    public function destroy($userId) {
        // Find the user by ID
        $broker = Broker::find($userId);

        if (!$broker) {
            return response()->json(['message' => 'broker not found'], 404);
        }

        $user = $broker->user;
        if ($user) {
            $broker->delete();
            $user->delete();
            return response()->json(['message' => 'broker deleted successfully']);
        }else{

        }


    }


    public function setStatus(Request $request, $brokerId) {


        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Failed'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $agent = Agent::find($brokerId);

        if (!$agent) {

            return $this->error('', 'Agent not found', 422);

        }

        // Update the status
        $agent->status = $request->status;
        $agent->save();

        return $this->success(['agent'=> new BrokerResource($agent)], 'Agent status updated successfully');
    }
}
