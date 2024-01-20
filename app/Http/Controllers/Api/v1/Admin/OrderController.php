<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\TransactionsResource;

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
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:Pending,Approved,Confirmed,Failed,Paid',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $order = Order::find($id);

        if (!$order) {
            return $this->error('', 'Order not found', 404);
        }

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
        $userOrders = $user->order()->latest()->paginate(10); // Assuming 'orders' is the relationship method name

        return OrderResource::collection($userOrders);
    }



    public function all_transactions(Request $request){

        $sort = $request->input('sort');
        $email = $request->input('email');
        $phone = $request->input('phone_number');
        $status = $request->input('status');
        $fullName = $request->input('full_name');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $date = $request->input('date');

        $order = Order::query();


    // Filter by 'sort' parameter
    if ($sort) {
        $order->orderBy($sort);
    }

    if ($email) {
        $order->whereHas('user', function ($userQuery) use ($email) {
            $userQuery->where('email', 'like', "%$email%");
        });
    }


    if ($phone) {
        $order->where('phone_number', 'like', "%$phone%");
    }

    if ($status) {
        $order->where('status', $status);
    }

    if ($fullName) {
        $order->whereHas('user', function ($userQuery) use ($fullName) {
            $userQuery->where('full_name', 'like', "%$fullName%");
        });
    }

    if ($startDate) {
        $order->whereDate('created_at', '>=', $startDate);
    }

    if ($date) {
        $order->whereDate('created_at', '=', $date);
    }

    if ($endDate) {
        $order->whereDate('created_at', '<=', $endDate);
    }

    $perPage = $request->input('per_page', 10);

    $order = $order->latest()->paginate($perPage);
    $totalAmount = $order->sum('amount');
    $totalFee = $order->sum('fee');

    return response()->json([
        'data' => TransactionsResource::collection($order),
        'total_transaction_amount' => $totalAmount,
        'total_transaction_fee' => $totalFee,
    ]);

    }
}
