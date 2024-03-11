<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\Bid;
use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use App\Models\QrCode;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BidResource;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\OrderResource;
use App\Http\Requests\LoadBoardRequest;
use App\Notifications\SendNotification;
use App\Http\Resources\LoadBoardResource;

class LoadBoardController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index(Request $request)
{
    $query = LoadBoard::where("acceptable_id", null)->where("status", 'pending');

    // Check if admin_approve in related order is 'Yes'
    $query->whereHas('order', function ($q) {
        $q->where('admin_approve', 'Yes');
    });

    // Filter by Order Number
    if ($request->has('order_no')) {
        $query->where('order_no', $request->input('order_no'));
    }

    $loadBoards = $query->get();

    return LoadBoardResource::collection($loadBoards);
}

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\LoadBoard  $loadBoard
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $loadBoard =  LoadBoard::find($id);
        return $this->success(['loadBoard' => new LoadBoardResource($loadBoard)], 'Load board retrieved successfully');
    }

    public function barCode(Request $request){

        $request->validate([
            'content' => 'required|string',
            'order_no' => 'nullable|string',
        ]);

        $qrCode = new QrCode();
        $qrCode->user_id = auth()->id();
        $qrCode->order_no = $request->order_no;
        $qrCode->content = $request->content;
        $qrCode->qr_link = generateQr($request->content);
        $qrCode->save();

        return $this->success(['data' => $qrCode], 'Qr Code generated updated successfully');


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


    public function accept(LoadBoard $loadBoard)
    {

     //   $loadBoard = LoadBoard::where('order_no', $orderNo)->first();
      //  return $loadBoard;
        if ($loadBoard) {
          $order = $loadBoard->order;

            $acceptedUser = User::find(Auth::user()->id);

            if ($acceptedUser) {
                $order->accepted ="Yes";
                $order->acceptable_id = $acceptedUser->id;
                $order->acceptable_type = get_class($acceptedUser);

                $order->save();

                $loadBoard->status = 'out_for_delivery';
                $order->acceptable_id = $acceptedUser->id;
                $order->acceptable_type = get_class($acceptedUser);
                $loadBoard->save();

                return $this->success(['loadBoard' => new LoadBoardResource($loadBoard)], 'Load accepted successfully');
            } else {
                // User who accepts the order not found
                return $this->success(null, 'User who accepts the order not found');

            }
        } else {
            // Order with the specified order number not found in load boards

            return $this->success(null, 'order with the specified order number not found in load boards');

        }
    }


    /**
     * bidStore
     *  this create bid for a load in loadboard
     * @param  mixed $request
     * @param  mixed $loadBoard
     *
     */
    public function bidStore(Request $request, LoadBoard $loadBoard){

        $request->validate([
            "amount" => ['required','numeric'],
        ]);

     //   return $loadBoard;
        $acceptedLoad = $loadBoard->where('acceptable_id',"=", null)->where("acceptable_type","=",null)->first();

        if (!$acceptedLoad) {
            return $this->error(null, 'This load has already been accepted by another driver.');
        }


        if($request->amount <= $loadBoard->order->amount){
            return $this->error(null, 'You can bid lower then amount');

        }

        // $bid = Bid::create([
        //     'order_id' => $loadBoard->order->id,
        //     'driver_id' => auth()->id(),
        //     'amount' => $request->amount,
        // ]);
         //   return $loadBoard->order->amount;

         if ($loadBoard->user_id ==auth()->id() ) {
            return $this->error(null, 'You cant bid on your placed order');
        }

         $bid = Bid::where("order_no",$loadBoard->order_no)->where("driver_id",auth()->id())->first();

         if ($bid) {
            return $this->error(null, 'You have already bid for this and is not yet to be confirmed');
        }

        $bid = new Bid();

        $bid->order_no =  $loadBoard->order_no;
        $bid->order_id =  $loadBoard->order->id;
        $bid->user_id =  $loadBoard->user_id;
        $bid->driver_id = auth()->id();
        $bid->amount =   $request->amount;
        $bid->old_amount =   $loadBoard->order->amount;

        $bid->save();

        // $bid = Bid::updateOrCreate(
        //     [
        //         'order_id' => $loadBoard->order->id,
        //         'order_no' => $loadBoard->order_no,
        //         'driver_id' => auth()->id(),
        //         'user_id' => $loadBoard->user_id,
        //     ],
        //     [
        //         'order_no' => $loadBoard->order_no,
        //         'order_id' => $loadBoard->order->id,
        //         'user_id' => $loadBoard->user_id,
        //         'driver_id' => auth()->id(),
        //         'amount' => $request->amount,
        //         'old_amount' => $loadBoard->order->amount,
        //     ]
        // );

        $message ="You have a new bid ". $acceptedLoad->order_no. " to delivery from: ".$acceptedLoad->loadable->sender_location." To: ".$acceptedLoad->loadable->receiver_location;
        $acceptedLoad->user->notify(new SendNotification($acceptedLoad->user, $message));

        return new BidResource($bid);

    }

    public function getAllBidsByLoadBoard(LoadBoard $loadBoard)
    {
        $bids = Bid::where('order_id', $loadBoard->order->id)->get();

        return BidResource::collection($bids);
    }


    public function getAllBidsByOrder(int $id)
    {
        $bids = Bid::where('order_id',$id)->get();

        return BidResource::collection($bids);
    }

    public function acceptBidByCustomer(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $bid = Bid::where('id', $request->bid_id)
                ->where('user_id', auth()->id())
                ->first();

            if (!$bid) {
                return $this->error(null, 'No bid or load found.');
            }

            $totalAmountIncrease = $bid->amount - $bid->order->amount;

            if ($totalAmountIncrease <= 0) {
                return $this->error(null, 'Bid price should be higher than the total amount.');
            }

            $userWalletAmount = $bid->user->wallet->amount;

            if ($totalAmountIncrease > $userWalletAmount) {
                return $this->error('', 'Insufficient funds in wallet!', 404);
            }

            // Deduct the difference from the user's wallet
            $bid->user->wallet->decrement('amount', $totalAmountIncrease);

            // Update the total amount of the order with the accepted bid price
            $bid->order->amount = $bid->amount;

            if($bid->order->save()){

                $driver = User::find($bid->driver_id);
                $loadBoard = LoadBoard::where('order_no', $bid->order_no)->first();
                $loadBoard->acceptable_id = $driver->id;
                $loadBoard->acceptable_type = get_class($driver);
                $loadBoard->save();

            // $bid->order->driver_id = $bid->driver_id;
                // $bid->order->acceptable_id = $bid->user->id;
                // $bid->order->acceptable_type =get_class($driver->user);
                $bid->order->save();

                $message ="Your bid has been accepted ". $bid->order->order_no. " to delivery from: ".$bid->order->loadable->sender_location." To: ".$bid->order->loadable->receiver_location;
                $driver->notify(new SendNotification($driver, $message));

            }

            return $this->success('Bid accepted successfully!');
        });
    }



    public function allDriverAssignOrders(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $driver = LoadBoard::whereHas('order', function ($q) {
            $q->where('placed_by_id', auth()->user()->id);
        })
        ->paginate($perPage);

      //  $order =  Order::where('driver_id', auth()->id())->paginate($perPage);

        return  LoadBoardResource::collection($driver);
    }

    public function allassignDriverToTruck(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $driver = LoadBoard::whereHas('order', function ($q) {
            $q->where('placed_by_id', auth()->user()->id);
        })
        ->paginate($perPage);

      //  $order =  Order::where('driver_id', auth()->id())->paginate($perPage);

        return  LoadBoardResource::collection($driver);
    }


    public function assignDriverToTruck(Request $request)
    {

        $request->validate([
            'truck_id' => 'required|exists:users,id',
            'driver_id' => 'required|exists:users,id',
            'order_no' => 'required|exists:load_boards,order_no',
        ]);

        $perPage = $request->input('per_page', 10);
        $loadBoard = LoadBoard::where('status','!=','delivered')->where('order_no',$request->order_no)->where('acceptable_id',$request->driver_id)->whereHas('order', function ($q) {
            $q->where('placed_by_id', auth()->user()->id);
        })
        ->first();


        if (!$loadBoard) {
            return $this->error([], "Order not found or you don't have pending driver with order to assign to truck!");
        }

        $loadBoard->order->truck_by_id = $request->truck_id;

        $loadBoard->order->save();

      //  $order =  Order::where('driver_id', auth()->id())->paginate($perPage);

        // return  new LoadBoardResource($loadBoard);

        return $this->success([
            new LoadBoardResource($loadBoard),
        ]);

    }


    public function reAssignDriverToTruck(Request $request)
    {

        $request->validate([
            'truck_id' => 'required|exists:users,id',
            'driver_id' => 'required|exists:users,id',
            'order_no' => 'required|exists:load_boards,order_no',
        ]);

        $perPage = $request->input('per_page', 10);
        $loadBoard = LoadBoard::where('status','!=','delivered')->where('order_no',$request->order_no)->first();

        Log::info($loadBoard);
        Log::info($request->truck_id);
        Log::info($request->order);
        
        // if (!$loadBoard) {
        //     return $this->error([], "Order not found or you don't have pending driver with order to assign to truck!");
        // }

        $loadBoard->order->truck_by_id = $request->truck_id;

        $loadBoard->order->save();

      //  $order =  Order::where('driver_id', auth()->id())->paginate($perPage);

        // return  new LoadBoardResource($loadBoard);

        return $this->success([
            new LoadBoardResource($loadBoard),
        ]);

    }


    /**
     * orderAssign
     * this function assign order to driver
     * @param  mixed $request
     * @return void
     */
    public function orderAssign(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_no' => 'required|exists:load_boards,order_no',
                'driver_id' => 'required|exists:users,id',
            ]);
            $driver = User::findOrFail($request->driver_id);
            $loadBoard = LoadBoard::where("order_no", $request->order_no)
                ->where("acceptable_id", auth()->user()->id)
                // ->where("status", 'pending')
                ->first();

            if (!$loadBoard) {
                return $this->error([], "Order not found or has already been taken!");
            }
            // Check if driver is already assigned to an order
            if ($loadBoard->acceptable_id == $driver->id) {
                return $this->error([], "Order has already been assigned to a driver!");
            }
            $order = Order::where("order_no", $request->order_no)->first();

            $loadBoard->acceptable_id = $driver->id;
            $loadBoard->acceptable_type = get_class($driver);
            $order->placed_by_id = auth()->user()->id;

            $loadBoard->save();
            $order->save();

            $message = "You have been assigned an order with number " . $loadBoard->order_no . " for delivery from: " . $loadBoard->order->loadable->sender_location . " to: " . $loadBoard->order->loadable->receiver_location;
            $driver->notify(new SendNotification($driver, $message));

            return $this->success([
                new OrderResource($order),
            ]);

        });
    }

    public function orderReAssign(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_no' => 'required|exists:load_boards,order_no',
                'driver_id' => 'required|exists:users,id',
            ]);
            $driver = User::findOrFail($request->driver_id);
            $loadBoard = LoadBoard::where("order_no", $request->order_no)
                //->where("acceptable_id", auth()->user()->id)
                // ->where("status", 'pending')
                ->first();

            if (!$loadBoard) {
                return $this->error([], "Order not found or has already been taken!");
            }
            // Check if driver is already assigned to an order
            if ($loadBoard->acceptable_id == $driver->id) {
                return $this->error([], "Order has already been assigned to a driver!");
            }
            $order = Order::where("order_no", $request->order_no)->first();

            $loadBoard->acceptable_id = $driver->id;
            $loadBoard->acceptable_type = get_class($driver);
            $order->placed_by_id = auth()->user()->id;

            $loadBoard->save();
            $order->save();

            $message = "You have been Re assigned an order with number " . $loadBoard->order_no . " for delivery from: " . $loadBoard->order->loadable->sender_location . " to: " . $loadBoard->order->loadable->receiver_location;
            $driver->notify(new SendNotification($driver, $message));

            return $this->success([
                new OrderResource($order),
            ]);

        });
    }


    public function removeOrder(Request $request)
    {
        return DB::transaction(function () use ($request) {

            $request->validate([
                'order_no' => 'required|exists:load_boards,order_no',
                'driver_id' => 'required|exists:users,id',
            ]);
            $driver = User::findOrFail($request->driver_id);
            $loadBoard = LoadBoard::where("order_no", $request->order_no)
                ->where("acceptable_id", $driver->id)
                // ->where("status", 'pending')
                ->first();

            if (!$loadBoard) {
                return $this->error([], "Order not found or this order doesn't belong to this driver");
            }

            $order = Order::where("order_no", $request->order_no)->first();

            $loadBoard->acceptable_id = auth()->user()->id;
            $loadBoard->acceptable_type = get_class($driver);
            $loadBoard->status = "processing";
           $order->placed_by_id = null;

            $loadBoard->save();
            $order->save();

            $message = "order with number " . $loadBoard->order_no . " for delivery from: " . $loadBoard->order->loadable->sender_location . " to: " . $loadBoard->order->loadable->receiver_location." has been removed";
            $driver->notify(new SendNotification($driver, $message));

            return $this->success([
                new OrderResource($order),
            ]);

        });
    }


        /**
     * acceptOrder
     *  this function is for driver manager to accept
     *  order from loadboard or loadbrocast
     * @param  mixed $request
     * @return void
     */
    public function acceptOrder(Request $request){

        return DB::transaction(function () use ($request) {

        $request->validate([
            'order_no' => 'required|string',
            //'driver_id' => 'required',
        ]);

        $loadBoards = LoadBoard::where("order_no",$request->order_no)->whereNull('acceptable_id')
        ->whereNull('acceptable_type')->first();

        if($loadBoards){
            $user = User::find(auth()->id());

            $loadBoards->acceptable_id = $user->id;
            $loadBoards->acceptable_type = get_class($user);
            $loadBoards->status = "processing";

            if($loadBoards->save()){
              //  $loadBoards->order->driver_id = $driver->user->id;
               // $loadBoards->order->accepted = "Yes";
               // $loadBoards->order->acceptable_id = $driver->user->id;
              //  $loadBoards->order->acceptable_type = get_class($driver->user) ;
              //  $loadBoards->order->placed_by_id = auth()->user()->id;
              $loadBoards->loadable->status = "processing";
                $loadBoards->order->save();

                $message ="You have been accept order with number ". $loadBoards->order->order_no.
                " to delivery FROM: ".$loadBoards->order->loadable->sender_location.", TO: ".$loadBoards->order->loadable->receiver_location;
                $user->notify(new SendNotification($user, $message));

            }

            return new OrderResource($loadBoards->order);
        }else{

            return $this->error([
            ], "This load has already been taken!");
        }

    });

    }

    public function order(Request $request)
    {

        $perPage = $request->input('per_page', 10);
        $driver = LoadBoard::where("acceptable_id",auth()->id())->paginate($perPage);
        //  $order =  Order::where('acceptable_id', $driver->user->id)
        // ->where('acceptable_type', get_class($driver->user))
        // ->paginate($perPage);

      //  $order =  Order::where('driver_id', auth()->id())->paginate($perPage);

        return  LoadBoardResource::collection($driver);
    }



    public function allUserOrder(Request $request, User $user)
    {

        $query = LoadBoard::where("acceptable_id",  $user->id);

        // Check if placed_by_id = auth()->user()->id; in related order is 'Yes'
        $query->whereHas('order', function ($q) {
            $q->where('placed_by_id', auth()->user()->id);
        });

        // Filter by Order Number
        if ($request->has('order_no')) {
            $query->where('order_no', $request->input('order_no'));
        }

        $loadBoards = $query->get();

        return LoadBoardResource::collection($loadBoards);
        // return  LoadBoardResource::collection($driver);
    }


    public function rejectOrder(Request $request){

        return DB::transaction(function () use ($request) {

        $request->validate([
            'order_no' => 'required|string',
            //'driver_id' => 'required',
        ]);

        $loadBoards = LoadBoard::where("order_no",$request->order_no)->where('acceptable_id',auth()->id())->first();

        if($loadBoards){

            $loadBoards->acceptable_id = null;
            $loadBoards->acceptable_type = null;
            $loadBoards->status = "Pending";

            if($loadBoards->save()){
             //   $loadBoards->order->driver_id = null;
            //    $loadBoards->order->accepted = "No";
             //   $loadBoards->order->acceptable_id = null;
              //  $loadBoards->order->acceptable_type = null;
              //  $loadBoards->order->placed_by_id = auth()->user()->id;
              $loadBoards->loadable->status = "Pending";
                $loadBoards->order->save();

                // $message ="You have rejected this load with ". $loadBoards->order->order_no.
                // " to delivery FROM: ".$loadBoards->order->loadable->sender_location.", TO: ".$loadBoards->order->loadable->receiver_location;
                // $driver->user->notify(new SendNotification($driver->user, $message));

            }

            return new OrderResource($loadBoards->order);
        }else{

            return $this->error([
            ], "This load doesn't belong to this driver");
        }

    });

    }


    // public function acceptBidByCustomer(Request $request){

    //     return DB::transaction(function () use ($request) {

    //     $bids = Bid::where('order_null', $request->order_no)->where('user', auth()->id())->first();

    //     if($bids){

    //     $TotalAmountIncrease =  $bids->amount - $bids->order->total_amount;

    //     $loadTotalAmount = number_format($TotalAmountIncrease, 2, '.', '');
    //     $userWalletAmount = number_format($bids->user->wallet->amount, 2, '.', '');

    //     if ($loadTotalAmount >= $userWalletAmount) {
    //         return $this->error('', 'Insufficient funds in wallet!', 404);
    //     }
    //     $bids->user->wallet->amount -= $TotalAmountIncrease;
    //     $bids->user->wallet->save();

    //     $bids->order->total_amount += $loadTotalAmount;

    //     $bids->order->save();

    //     }else{
    //         return $this->error(null, 'no bid or load found.');

    //     }

    // });

    // }

}
