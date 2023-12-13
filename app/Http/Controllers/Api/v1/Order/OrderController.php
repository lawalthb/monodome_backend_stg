<?php

namespace App\Http\Controllers\Api\v1\Order;

use App\Models\Order;
use App\Models\LoadType;
use App\Models\PriceSetting;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Models\DistanceSetting;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Notifications\SendNotification;
use App\Http\Resources\DistanceSettingResource;

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

            //  $load = $specificType->where('id', $request->load_id)->first();
            $load = $specificType->where('id', $request->load_id)->lockForUpdate()->first();

             if (!$load) {
                 return $this->error('', 'Load not found', 404);
             }

             if (!$load->user->wallet) {
                 return $this->error('', 'Wallet not set up', 404);
             }

             if ($load->total_amount == 0) {
                 return $this->error('', 'Order amount cannot be zero', 404);
             }

             $loadTotalAmount = number_format($load->total_amount, 2, '.', '');
             $userWalletAmount = number_format($load->user->wallet->amount, 2, '.', '');

             if ($loadTotalAmount >= $userWalletAmount) {
                 return $this->error('', 'Insufficient funds in wallet!', 404);
             }

             $existingOrder = Order::where([
                 'user_id' => Auth::id(),
                 'loadable_id' => $load->id,
                 'loadable_type' => get_class($load),
                 'status' => 'Paid',
             ])->first();

             if ($existingOrder) {
                 return $this->error('', 'This order has already been paid!', 404);
             }

             $load->user->wallet->amount -= $loadTotalAmount;
             $load->status = 'Waiting';
             $load->save();

             $order = Order::updateOrCreate(
                 [
                     'user_id' => $load->user_id,
                     'loadable_id' => $load->id,
                     'loadable_type' => get_class($load),
                 ],
                 [
                  //   'driver_id' => 1,
                     'amount' => $loadTotalAmount,
                     'status' => 'Paid',
                 ]
             );

             $order->loadable()->associate($load);

             if ($order->save()) {
                 $walletHistory = new WalletHistory;
                 $walletHistory->wallet_id = $load->user->wallet->id;
                 $walletHistory->user_id = $load->user->id;
                 $walletHistory->type = "debit";
                 $walletHistory->payment_type = "wallet";
                 $walletHistory->amount = $load->total_amount;
                 $walletHistory->closing_balance = $load->user->wallet->amount;
                 $walletHistory->fee = 0;
                 $walletHistory->description = "Payment for Order with the follow ID: " . $order->order_no . " !";
                 $walletHistory->save();

                 $order->user->notify(new SendNotification($order->user, 'Your order was successful!'));
                 event(new LoadTypeCreated($load));

                 return $this->success(new OrderResource($order), 'Order payment was successful');
             } else {
                 return $this->error([], 'Error placing order', 500);
             }
         });
     }


    // public function store(OrderRequest $request)
    // {
    //     $loadType = LoadType::find($request->load_type_id);

    //     if (!$loadType) {

    //         return $this->error('', 'LoadType not found', 404);
    //     }

    //     $specificType = $loadType->specificType;
    //     if (!$specificType) {
    //         return $this->error('', 'Specific type not found', 404);
    //     }

    //     //this get load to pay
    //     $load = $specificType->where('id', $request->load_id)->first();

    //     if (!$load) {
    //         return $this->error('', 'Load not found', 404);
    //     }

    //     if (!$load->user->wallet) {
    //         return $this->error('', 'wallet not setup', 404);
    //     }

    //     if ($load->total_amount == 0) {
    //         return $this->error('', 'order amount cant be zero', 404);
    //     }

    //    // Log::info($loadType->loadable_type);

    //     $loadTotalAmount = number_format($load->total_amount, 2, '.', ''); // Format as a string with 2 decimal places
    //     $userWalletAmount = number_format($load->user->wallet->amount, 2, '.', '');

    //     if ($loadTotalAmount >= $userWalletAmount) {
    //         return $this->error('', 'Insufficient funds in wallet!', 404);
    //     }

    //    // $order = Order::where(['user_id'=>Auth::id(),'loadable_id'=>$load->id,'status'=>'Paid'])->first();
    //    $order = Order::where([
    //        'user_id' => Auth::id(),
    //        'loadable_id' => $load->id,
    //        'loadable_type' => get_class($load), // Add loadable_type condition
    //        'status' => 'Paid',
    //        ])->first();

    //      //  Log::info($order);
    //     if($order){
    //         return $this->error('', 'This Order has already been paid!', 404);

    //     }
    //     $load->user->wallet->amount =  $load->user->wallet->amount - $loadTotalAmount;

    //    // ,'Approved','Processing'
    //     $load->status = 'Waiting';
    //     $load->save();
    //     $order = Order::updateOrCreate(
    //         [
    //             'user_id' => $load->user_id,
    //             'loadable_id' => $load->id, // Add loadable_id condition
    //             'loadable_type' => get_class($load),
    //         ],
    //         [
    //          //   'order_no' => getNumber(),
    //             'driver_id' => 1,
    //             'amount' => $loadTotalAmount,
    //             'status' => "Paid",
    //         ]
    //     );

    //     // Associate the order with the load
    //     $order->loadable()->associate($load);
    //     //  $order->save();

    //     if ($order->save()) {

    //            // Create a wallet history entry
    //            $walletHistory = new WalletHistory;
    //            $walletHistory->wallet_id = $load->user->wallet->id;
    //            $walletHistory->user_id =$load->user->id;
    //            $walletHistory->type = "debit";
    //            $walletHistory->payment_type = "wallet";
    //            $walletHistory->amount = $load->total_amount;
    //            $walletHistory->closing_balance = $load->user->wallet->amount;
    //            $walletHistory->fee = 0;
    //            $walletHistory->description = "Payment for Order with the follow ID: ".$order->order_no. " !";
    //            $walletHistory->save();


    //         $message ="Your Order with the follow ID: ".$order->order_no. " was successfully!";
    //         $order->user->notify(new SendNotification($order->user, $message));

    //         event(new LoadTypeCreated($load));

    //         return $this->success(new OrderResource($order), 'Order payment was successfully');
    //     } else {

    //         return $this->error([], 'Error placing other', 500);
    //     }
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $order = Order::find($id);

        if (!$order) {

            return $this->error('', 'shipping order not found', 422);

        }

        return new OrderResource($order);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function calculatePrice(Request $request)
    {
        $request->validate([
            'distance' => 'required|string',
            'type' => 'required|string|in:Packages,Documents,Bulk Delivery,Car Clearing,Car Delivery,Container Delivery',
        ]);

        $payload = $request->all();
        $type = $request->type;

        $distance = (int)filter_var($payload['distance'], FILTER_SANITIZE_NUMBER_INT);

        // Find the related PriceSetting by name
        $priceSetting = PriceSetting::where('name', $type)->first();

        if (!$priceSetting) {
            return response()->json(['message' => 'No matching price settings found.'], 404);
        }

        // Now you can find the matching distance setting
        $distanceSetting = DistanceSetting::where('loadable_id', $priceSetting->id)
            ->where('from', '<=', $distance)
            ->where('to', '>=', $distance)
            ->first();

        if (!$distanceSetting) {
            return response()->json(['message' => 'No matching distance settings found.'], 404);
        }

        // Calculate the final price
        $finalPrice = $distanceSetting->price;

        return response()->json([
            'success' => true,
            'message' => 'Price calculation successful',
            'data' => ['final_price' => $finalPrice],
        ]);
    }

    // check the distance prices
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
}
