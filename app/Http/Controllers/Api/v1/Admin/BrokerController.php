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


    public function destroy($brokerId)
    {
        try {
            // Find the driver by ID
            $driver = Broker::with('user')->find($brokerId);

        if (!$driver) {
                return $this->error('', 'driver not found', 404);
            }

            if ( $user = $driver->user) {
                $driver->delete();

                $user->delete();

            return $this->success([], 'driver and user deleted successfully');

        }
        } catch (\Exception $e) {
            return $this->error('', 'Unable to delete driver and user', 500);
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
