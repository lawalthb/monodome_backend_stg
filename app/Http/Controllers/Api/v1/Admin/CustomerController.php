<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    use ApiStatusTrait,FileUploadTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $users = User::role('customer')->with('order')
        ->where(function ($q) use ($key) {
            $q->where('full_name', 'like', "%{$key}%")
                ->orWhere('email', 'like', "%{$key}%")
                ->orWhere('phone_number', 'like', "%{$key}%");
        })
        ->latest()
        ->paginate($perPage);

        return UserResource::collection($users);
    }

    public function totalOrder(Request $request, User $user){

        $perPage = $request->input('per_page', 10);

        $order = Order::where('user_id', $user->id) ->latest()
        ->paginate($perPage);

        return OrderResource::collection($order);
    }


    public function search(Request $request)
    {
        $searchTerm = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $users = User::role('customer')
            ->where(function ($query) use ($searchTerm) {
                $query->where('email', 'like', "%$searchTerm%")
                    ->orWhere('full_name', 'like', "%$searchTerm%")
                    ->orWhere('phone_number', 'like', "%$searchTerm%");
            })
            ->latest()
            ->paginate($perPage);

        return UserResource::collection($users);
    }


    public function show($userId) {
        $customer = User::role('customer')->find($userId);

        if (!$customer) {

            return $this->error('', 'customer not found', 422);

        }

        return new UserResource($customer);
    }


    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $user = User::role('customer')->findOrFail($id);

            if ($user) {
                // If the user has an associated customer, update its information
            $user->full_name = $request->input('full_name');
            $user->email = $request->input('email');
            $user->address = $request->input('address');
            $user->phone_number = $request->input('phone_number');
            $user->save();

            }
            DB::commit();

            return $this->success(new UserResource($user), 'customer updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return $this->error('An error occurred while updating the customer');
        }
    }


    public function destroy($brokerId)
    {
        try {
            // Find the driver by ID
            $user = User::role('customer')->find($brokerId);

        if (!$user) {
                return $this->error('', 'customer not found', 404);
            }
                $user->delete();

            return $this->success([], 'customer deleted successfully');

        } catch (\Exception $e) {
            return $this->error('', 'Unable to delete customer', 500);
        }
    }


    public function banned(){

    $user = User::where("status","Banned")->get();

    return $this->success(new UserResource($user), 'Banned customer successfully');

    }


    public function pending(){

        $user = User::where("status","Pending")->get();

        return $this->success(new UserResource($user), 'Pending customer successfully');

    }


    public function confirmed(){

        $user = User::where("status","Confirmed")->get();

        return $this->success(new UserResource($user), 'confirmed customer successfully');

    }


    public function setStatus(Request $request, $userId) {


        $validator = Validator::make($request->all(), [
            'status' => ['required', 'string','in:Pending,Confirmed,Rejected,Banned'],
        ]);

        if ($validator->fails()) {
            return $this->error('', $validator->errors()->first(), 422);
        }

        $user = User::find($userId);

        if (!$user) {

            return $this->error('', 'customer not found', 422);

        }

        // Update the status
        $user->status = $request->status;
        $user->save();

        return $this->success(['customer'=> new UserResource($user)], 'customer status updated successfully');
    }
}
