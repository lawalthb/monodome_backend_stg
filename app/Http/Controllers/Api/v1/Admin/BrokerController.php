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
use Illuminate\Support\Facades\Validator;

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
        // Get query parameters from the request
        $sort = $request->input('sort');
        $email = $request->input('email');
        $phone_number = $request->input('phone_number');
        $nin_number = $request->input('nin_number');
        $status = $request->input('status');
        $state_name = $request->input('state_name');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        $date = $request->input('date');


        // Apply filters to the Broker query
        $brokers = Broker::query();

        // Filter by 'sort' parameter
        if ($sort) {
            $brokers->orderBy($sort);
        }

        // Filter by 'email' parameter
        if ($email) {
            $brokers->whereHas('user', function ($userQuery) use ($email) {
                $userQuery->where('email', 'like', "%$email%");
            });
        }

        // Filter by 'phone_number' parameter
        if ($phone_number) {
            $brokers->where('phone_number', 'like', "%$phone_number%");
        }

        // Filter by 'nin_number' parameter
        if ($nin_number) {
            $brokers->where('nin_number', 'like', "%$nin_number%");
        }

        // Filter by 'status' parameter
        if ($status) {
            $brokers->where('status', 'like', "%$status%");
        }

        // Filter by 'state_name' parameter
        if ($state_name) {
            $brokers->whereHas('state', function ($stateQuery) use ($state_name) {
                $stateQuery->where('name', 'like', "%$state_name%");
            });
        }

         // Filter by 'date' parameter (created_at date)
    if ($date) {
        $brokers->whereDate('created_at', $date);
    }


    // Filter by date range
                if ($start_date) {
                    $brokers->whereDate('created_at', '>=', $start_date);
                }

                if ($end_date) {
                    $brokers->whereDate('created_at', '<=', $end_date);
                }

        $perPage = $request->input('per_page', 10);

        // Retrieve and paginate the results
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


    public function pending(Request $request){

        $perPage = $request->input('per_page', 10);

       $brokers = Broker::query();


       $brokers = $brokers->whereIn('status', ['Pending','Rejected'])->latest()->paginate($perPage);

       return BrokerResource::collection($brokers);
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


    public function destroy($brokerId)
    {
        try {
            // Find the driver by ID
            $broker = Broker::with('user')->find($brokerId);

        if (!$broker) {
                return $this->error('', 'Broker not found', 404);
            }

            if ( $user = $broker->user) {
                $broker->delete();

                $user->delete();

            return $this->success([], 'Broker and user deleted successfully');

        }
        } catch (\Exception $e) {
            return $this->error('', 'Unable to delete Broker and user', 500);
        }
    }


    public function setStatus(Request $request, $brokerId) {


        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Failed'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $broker = Broker::find($brokerId);

        if (!$broker) {

            return $this->error('', 'broker not found', 422);

        }

        // Update the status
        $broker->status = $request->status;
        $broker->save();

        return $this->success(['broker'=> new BrokerResource($broker)], 'Agent status updated successfully');
    }
}
