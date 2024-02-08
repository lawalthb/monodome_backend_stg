<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\Bid;
use App\Models\User;
use App\Models\Order;
use App\Models\Driver;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\BidResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoadBoardRequest;
use App\Notifications\SendNotification;
use App\Http\Resources\LoadBoardResource;

class LoadBoardController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index(Request $request)
    {

        $query = LoadBoard::where("acceptable_id",null);

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
    public function show($id)
    {
        $loadBoard =  LoadBoard::find($id);
        return $this->success(['loadBoard' => new LoadBoardResource($loadBoard)], 'Load board retrieved successfully');
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
        $bid = Bid::updateOrCreate(
            [
                'order_id' => $loadBoard->order->id,
                'order_no' => $loadBoard->order_no,
                'driver_id' => auth()->id(),
                'user_id' => $loadBoard->user_id,
            ],
            [
                'amount' => $request->amount,
                'old_amount' => $loadBoard->order->amount,
            ]
        );

        $message ="You have a new bid ". $acceptedLoad->order_no. " to delivery from: ".$acceptedLoad->loadable->sender_location." To: ".$acceptedLoad->loadable->receiver_location;
        $acceptedLoad->user->notify(new SendNotification($acceptedLoad->user, $message));

        return new BidResource($bid);

    }

    public function getAllBidsByLoadBoard(LoadBoard $loadBoard)
    {
        $bids = Bid::where('order_id', $loadBoard->order->id)->get();

        return BidResource::collection($bids);
    }


    public function getAllBidsByOrder(Order $order)
    {
        $bids = Bid::where('order_id',$order->id)->get();

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
            $driver = Driver::find($bid->driver_id);
            $bid->order->driver_id = $bid->driver_id;
            $bid->order->acceptable_id = $bid->driver_id;
            $bid->order->acceptable_type =get_class($driver);
            $bid->order->save();

            $message ="Your bid has been accepted ". $bid->order->order_no. " to delivery from: ".$bid->order->loadable->sender_location." To: ".$bid->order->loadable->receiver_location;
            $driver->user->notify(new SendNotification($driver->user, $message));

        }

        return $this->success('Bid accepted successfully!');
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
