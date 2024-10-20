<?php

namespace App\Http\Controllers\Api\v1\Order;

use App\Models\Order;
use App\Models\Setting;
use App\Models\LoadType;
use App\Models\LoadBoard;
use App\Models\WeightPrice;
use App\Models\CarYearPrice;
use App\Models\PriceSetting;
use Illuminate\Http\Request;
use App\Models\CarStatePrice;
use App\Models\CarValuePrice;
use App\Models\DistancePrice;
use App\Services\WalletService;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Models\CarCountryPrice;
use App\Models\DistanceSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Notifications\SendNotification;
use App\Http\Resources\WeightPriceResource;
use App\Http\Resources\DistanceSettingResource;
use App\Models\CarsContainerValuePrice;
use App\Models\OtherContainerValuePrice;

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
            $q->whereHas('user', function ($userQuery) use ($key) {
                $userQuery->where('full_name', 'like', "%{$key}%");
            })->orWhere('order_no', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

        return OrderResource::collection($agents);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $loadType = LoadType::find($request->load_type_id);

            if (!$loadType) {
                return $this->error('', 'LoadType not found', 404);
            }

            $specificType = $loadType->specificType;

            if (!$specificType) {
                return $this->error('', 'Specific type not found', 404);
            }

            $load = $specificType->where('id', $request->load_id)->lockForUpdate()->first();

            if (!$load) {
                return $this->error('', 'Load not found', 404);
            }

            if ($request->payment_type == "wallet" && !$load->user->wallet) {
                return $this->error('', 'Wallet not set up', 404);
            }

            if ($load->total_amount == 0) {
                return $this->error('', 'Order amount cannot be zero', 404);
            }

            $loadTotalAmount = number_format($load->total_amount, 2, '.', '');
            $userWalletAmount = number_format($load->user->wallet->amount, 2, '.', '');

            if (($request->payment_type == "wallet") && ($loadTotalAmount >= $userWalletAmount)) {
                return $this->error('', 'Insufficient funds in wallet!', 404);
            }

            $existingOrder = Order::where([
                'user_id' => Auth::id(),
                'loadable_id' => $load->id,
                'loadable_type' => get_class($load),
                'payment_status' => 'Paid',
            ])->first();

            if ($existingOrder) {
                return $this->error('', 'This order has already been paid!', 404);
            }

            // Remove money from wallet of users
            if ($request->payment_type == "wallet") {
                WalletService::updateWallet($load->user, [
                    'amount' => $loadTotalAmount,
                    'type' => 'debit',
                    'payment_type' => 'wallet',
                    'description' => "Payment for Order ID: " . $load->id,
                ]);
            }

            $load->save();

            $order = Order::updateOrCreate(
                [
                    'user_id' => $load->user_id,
                    'loadable_id' => $load->id,
                    'loadable_type' => get_class($load),
                ],
                [
                    'amount' => $loadTotalAmount,
                    'payment_type' => $request->payment_type,
                ]
            );

            $order->loadable()->associate($load);
            event(new LoadTypeCreated($load));

            $securityPin = getOTPNumber(6);

            // Update the order with the security pin
            $order->security_pin =  $securityPin;
            $order->save();

            // Send notification with security pin
            $order->user->notify(new SendNotification($order->user, 'Your order has been placed successfully! Use this security pin to receive your package: ' . $securityPin));


            // Payment for wallet goes here
            if ($request->payment_type == "wallet" && $order->save()) {
                $order->payment_type = 'wallet';
                $order->payment_status = 'Paid';
                $order->save();


                $order->user->notify(new SendNotification($order->user, 'Your wallet payment order was successful!'));

                return $this->success(new OrderResource($order), 'Wallet Order payment was successful');
            }

            // Offline payment
            if ($request->payment_type == "offline") {
                $order->payment_type = 'offline';
                $order->payment_status = 'Pending';
                $order->save();

                $order->user->notify(new SendNotification($order->user, 'Your offline order was successful!'));

                return $this->success(new OrderResource($order), 'Offline Order was successful');
            }

            // Payment gateway
            if ($request->payment_type == "online") {
                $order->payment_type = 'online';
                $order->payment_status = 'Pending';
                $order->save();

                $customFields = [
                    [
                        "order_no" => $order->id,
                        "from" => "order"
                    ],
                ];

                $fields = [
                    'email' => $order->user->email,
                    'amount' => $loadTotalAmount * 100,
                    "metadata" => json_encode(['id' => $order->id, 'custom_fields' => $customFields]),
                    'callback_url' => env('FE_APP_URL') . '/customer'
                ];

                $result = payStack_checkout($fields);

                return $this->success(["paystack" => $result->data], 'Gateway Order was successful');
            }

            return $this->success(null, 'Order was successful');
        });
    }

    public function cancelOrder(Request $request)
    {
        $request->validate([
            'order_no' => 'required|string',
        ]);

        return DB::transaction(function () use ($request) {
            $order = Order::where("order_no", $request->order_no)->first();

            if (!$order) {
                return $this->error('', 'Order not found', 404);
            }

            if ($order->payment_type != 'wallet' && $order->payment_type != 'online') {
                return $this->error('', 'Cancellation allowed only for wallet and online payments', 400);
            }

            if (!is_null($order->driver_id)) {
                return $this->error('', 'Order cannot be cancelled once a driver is assigned', 400);
            }

            // Mark the order as cancelled
            $order->payment_status = 'Pending';
            $order->save();

            $loadBoard = LoadBoard::where("order_no", $order->order_no)->first();
            $loadBoard->acceptable_id = null;
            $loadBoard->acceptable_type = null;
            $loadBoard->status = "pending";
            $loadBoard->status_comment = "Order cancelled by user";
            $loadBoard->save();

            $order->user->notify(new SendNotification($order->user, 'Your order was cancelled and your money will be refunded when admin approve it'));

            return $this->success(new OrderResource($order), 'Order cancelled and refunded successfully');
        });
    }

    public function show(string $id)
    {
        $order = Order::find($id);

        if (!$order) {
            return $this->error('', 'Shipping order not found', 422);
        }

        return new OrderResource($order);
    }

    public function calculatePrice(Request $request)
    {
        $request->validate([
            'is_document' => 'nullable|string|in:Yes,No',
            'distance' => 'required|string',
            'weight_id' => 'nullable',
            'load_type_id' => 'required|integer|exists:load_types,id',
        ]);

        $payload = $request->all();
        $load_type_id = $request->load_type_id;
        $weight_id = $request->weight_id;

        $distance = (int)filter_var($payload['distance'], FILTER_SANITIZE_NUMBER_INT);

        if ($request->is_document == "Yes") {
            $distanceSetting = DistancePrice::where('load_type_id', $load_type_id)
                ->where('min_km', '<=', $distance)
                ->where('max_km', '>=', $distance)
                ->first();

            $finalPrice = $distanceSetting->price;

            return response()->json([
                'success' => true,
                'message' => 'Price calculation successful',
                'data' => ['final_price' => $finalPrice],
            ]);
        }

        $WeightPrice = WeightPrice::where('id', $weight_id)->first();

        if (!$WeightPrice) {
            return response()->json(['message' => 'No matching price settings found.'], 404);
        }

        $distanceSetting = DistancePrice::where('load_type_id', $load_type_id)
            ->where('min_km', '<=', $distance)
            ->where('max_km', '>=', $distance)
            ->first();

        if (!$distanceSetting) {
            return response()->json(['message' => 'No matching distance settings or load found.'], 404);
        }

        $finalPrice = $distanceSetting->price + $WeightPrice->price;

        return response()->json([
            'success' => true,
            'message' => 'Price calculation successful',
            'data' => ['final_price' => $finalPrice],
        ]);
    }

    public function distancePrice()
    {
        $groupedDistanceSettings = DistanceSetting::with('loadable')
            ->get()
            ->groupBy(function ($item) {
                return $item->loadable->name;
            });

        $result = [];
        foreach ($groupedDistanceSettings as $name => $settings) {
            $result[] = [
                'price_setting_name' => $name,
                'distance_settings' => DistanceSettingResource::collection($settings),
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Distance settings grouped by Price Setting',
            'data' => $result,
        ]);
    }

    public function weight()
    {
        $weightPrices = WeightPrice::whereIn("load_type_id", [1, 6])->get();
        return WeightPriceResource::collection($weightPrices);
    }

    public function weightBulk()
    {
        $weightPrices = WeightPrice::where("load_type_id", 2)->get();
        return WeightPriceResource::collection($weightPrices);
    }

    public function calculateCarClearing(Request $request)
    {
        $validatedData = $request->validate([
            'country_id' => 'required|integer|exists:car_country_prices,id',
            'car_year' => 'required|integer|between:1990,2024',
            'car_value' => 'required',
            'load_type_id' => 'required|integer|exists:load_types,id',
            'final' => 'required|string|in:Yes,No',
            'state_id' => 'required_if:final,Yes|integer|exists:states,id',
        ]);

        $carValue = CarValuePrice::where('min', '<=', $validatedData['car_value'])
            ->where('max', '>=', $validatedData['car_value'])
            ->first();

        if (!$carValue) {
            return response()->json(['message' => 'No car value price found.'], 404);
        }

        $carValuePrice = $carValue->price;

        $carYear = CarYearPrice::where("year", $validatedData['car_year'])->first();

        if (!$carYear) {
            return response()->json(['message' => 'No car year price found.'], 404);
        }

        $carYearPrice = $carYear->price;

        $carCountryPrice = CarCountryPrice::findOrFail($validatedData['country_id'])->price;

        $total = $carYearPrice + $carCountryPrice + $carValuePrice;

        if ($request->final === "Yes") {
            $carStatePrice = CarStatePrice::findOrFail($validatedData['state_id'])->price;
            $total += $carStatePrice;
        }

        return response()->json([
            'success' => true,
            'message' => 'Price calculation successful',
            'data' => ['final_price' => $total],
        ]);
    }


    public function calculateContainer(Request $request)
    {
        // Validate the inputs
        $validatedData = $request->validate([
            'load_type_id' => 'required|integer|exists:load_types,id',
            'final' => 'required|string|in:Yes,No',
            'state_id' => 'required_if:final,Yes|integer|exists:states,id',
            'country_id' => 'required|integer|exists:countries,id',
            'cars_in_container' => 'required|array|min:1',
            'cars_in_container.*.car_model' => 'required|integer',
            'cars_in_container.*.car_type' => 'required|integer',
            'cars_in_container.*.year' => 'required|integer|between:1990,2024',
            'cars_in_container.*.amount' => 'required|numeric|min:0',
            'other_contents_in_container' => 'required|array|min:1',
            'other_contents_in_container.*.name' => 'required|string',
            'other_contents_in_container.*.amount' => 'required|numeric|min:0',
        ]);

        // Calculate the total amount of cars in the container
        $totalCarAmount = collect($validatedData['cars_in_container'])->sum('amount');

        // Check the carsContainerValuePrice table
        $carValuePrice = CarsContainerValuePrice::where('min', '<=', $totalCarAmount)
            ->where('max', '>=', $totalCarAmount)
            ->first();

        if (!$carValuePrice) {
            return response()->json(['message' => 'No car value price found for the given amount.'], 404);
        }

        // Calculate the total amount of other contents in the container
        $totalOtherAmount = collect($validatedData['other_contents_in_container'])->sum('amount');

        // Check the otherContainerValuePrice table
        $otherValuePrice = OtherContainerValuePrice::where('min', '<=', $totalOtherAmount)
            ->where('max', '>=', $totalOtherAmount)
            ->first();

        if (!$otherValuePrice) {
            return response()->json(['message' => 'No other contents value price found for the given amount.'], 404);
        }

        // Calculate the total prices
        $carValuePriceAmount = $carValuePrice->price;
        $otherValuePriceAmount = $otherValuePrice->price;

        $total_price = $carValuePriceAmount + $otherValuePriceAmount;

        // Return the calculated values along with the total amounts
        return response()->json([
            'success' => true,
            'message' => 'Price calculation successful',
            'data' => [
                'final_price' => $total_price,
                'total_car_amount' => $totalCarAmount,
                'car_value_price' => $carValuePriceAmount,
                'total_other_amount' => $totalOtherAmount,
                'other_value_price' => $otherValuePriceAmount,
            ],
        ]);
    }

    public function validateOrderPin(Request $request)
    {
        $request->validate([
            'order_no' => 'required|string',
            'pin' => 'required|numeric',
        ]);

        $orderNo = $request->input('order_no');
        $pin = $request->input('pin');

        // Find the order by order_no
        $order = Order::where('order_no', $orderNo)->first();

        if (!$order) {
            return $this->error('Order not found', 404);
        }

        // Validate the pin
        if ($order->security_pin === $pin) {


            $loadBoard = LoadBoard::where('order_no', $orderNo)->first();

            if (!$loadBoard) {
                return $this->error('LoadBoard entry not found', 404);
            }

            $loadBoard->status = 'delivered';
            $loadBoard->save();

            return $this->success('Pin validation successful');
        } else {
            return $this->error('Invalid pin', 400);
        }
    }

    public function getPinByOrderNo(Request $request)
{
    $orderNo = $request->input('order_no');

    // Find the order by order_no
    $order = Order::where('order_no', $orderNo)->first();

    if (!$order) {
        return $this->error('Order not found', 404);
    }

    // Return the security pin
    return $this->success(['security_pin' => $order->security_pin], 'Security pin retrieved successfully');
}

}
