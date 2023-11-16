<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{

    use ApiStatusTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $agents = Order::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('order_no', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return OrderResource::collection($agents);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);

        if (!$order) {

            return $this->error('', 'order not found', 422);

        }

        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->error('', 'Order not found', 404);
        }

        // Assuming 'status' is the field to update
        $order->status = $request->input('status');
        $order->save();

        return new OrderResource($order);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->error('', 'Order not found', 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully']);
    }


    public function all_user_orders($id)
    {
        $user = User::findOrFail($id); // Retrieve the authenticated user

        if (!$user) {
            return $this->error('', 'User not', 401);
        }

        // Retrieve all orders associated with the authenticated user
        $userOrders = $user->orders()->get(); // Assuming 'orders' is the relationship method name

        return OrderResource::collection($userOrders);
    }
}
