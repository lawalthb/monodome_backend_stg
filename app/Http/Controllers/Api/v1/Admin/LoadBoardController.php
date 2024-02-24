<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Order;
use App\Models\Driver;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Http\Requests\LoadBoardRequest;
use App\Notifications\SendNotification;
use App\Http\Resources\LoadBoardResource;
use Illuminate\Support\Facades\Validator;

class LoadBoardController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index(Request $request)
    {

        $query = LoadBoard::query();

       // Filter by Cargo Type
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        // // Filter by Country
        // if ($request->has('country')) {
        //     $query->where('country', $request->input('country'));
        // }

        // // Filter by Pickup Distance
        // if ($request->has('pickup_distance')) {
        //     $query->where('pickup_distance', $request->input('pickup_distance'));
        // }

        $loadBoards = $query->get();

        return LoadBoardResource::collection($loadBoards);
        // return $this->success(['loadBoards' => $loadBoards], 'Load boards retrieved successfully');
    }


     /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoadBoard  $loadBoard
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(LoadBoard $loadBoard)
    {
        return $this->success(['loadBoard' => $loadBoard], 'Load board retrieved successfully');
    }


    public function store(LoadBoardRequest $request)
    {
        $data = $request->validated();
       // $data['uuid'] = Str::uuid()->toString();

        $loadBoard = LoadBoard::create($data);

        return $this->success(['loadBoard' => $loadBoard], 'Load board created successfully');
    }


    public function update(LoadBoardRequest $request, LoadBoard $loadBoard)
    {
        $data = $request->validated();
        $loadBoard->update($data);

        return $this->success(['loadBoard' => $loadBoard], 'Load board updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\LoadBoard  $loadBoard
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(LoadBoard $loadBoard)
    {
        $loadBoard->delete();

        return $this->success(null, 'Load board deleted successfully');
    }


    public function loadBoardOrderStatus(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,on_transit,delivered,rejected,complicated',
            'order_no' => 'required|string|exists:load_boards,order_no',
            'status_comment' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $loadBoard = LoadBoard::where("order_no",$request->order_no)->first();
        if(!$loadBoard){
            return response()->json([
                'error' => "Order your found or order is not yours",
            ],400);
        }


        $loadBoard->status = $request->status;
        $loadBoard->status_comment = $request->status_comment;

        if($loadBoard->save()){

            $loadBoard->user->notify(new SendNotification($loadBoard->user, 'Your order status has been changed to!'.$request->status.' '));

            return response()->json([
                'data' => new LoadBoardResource($loadBoard),
            ],200);
        }else{
            return response()->json([
                'error' => "unable to update the status on loadBoard.",
            ],400);
        }

    }


    public function orderAssign(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_no' => 'required',
                'driver_id' => 'required',
            ]);

            $driver = Driver::find($request->driver_id);
            $loadBoard = LoadBoard::where("order_no", $request->order_no)
                ->where("acceptable_id", null)
              //  ->where("status", 'pending')
                ->first();

            $order = Order::where("order_no", $request->order_no)
              //  ->where("driver_id", null)
                ->first();

            if (!$order) {
                return $this->error([], "Order already assigned or doesn't exist!");
            }

            if (!$driver) {
                return $this->error([], "Driver not found!");
            }

            $loadBoard->acceptable_id = $driver->id;
            $loadBoard->acceptable_type = get_class($driver);
            $loadBoard->save();

            $message = "You have been assigned an order with number " . $order->order_no . " for delivery from: " . $order->loadable->sender_location . " to: " . $order->loadable->receiver_location;
            $driver->user->notify(new SendNotification($driver->user, $message));

            return $this->success([
                new OrderResource($order),
            ]);

        });
    }


}

