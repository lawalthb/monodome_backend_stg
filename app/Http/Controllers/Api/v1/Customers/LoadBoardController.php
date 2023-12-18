<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\Bid;
use App\Models\User;
use App\Models\LoadBoard;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Resources\BidResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoadBoardRequest;
use App\Http\Resources\LoadBoardResource;

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

            // Get the user who accepts the order (in this case, assuming it's a user with an ID of 1)
            $acceptedUser = User::find(Auth::user()->id); // Replace 1 with the ID of the accepting user

            if ($acceptedUser) {
                // Update the order and associate it with the accepting user
                $order->accepted ="Yes";
                $order->acceptable_id = $acceptedUser->id;
                $order->acceptable_type = get_class($acceptedUser); // Assuming it's User model

                $order->save();

                // Optionally, you can update the LoadBoard status or perform other actions if needed
                $loadBoard->status = 'out_for_delivery';
                $order->acceptable_id = $acceptedUser->id;
                $order->acceptable_type = get_class($acceptedUser); // Assuming it's User model
                $loadBoard->save();

                // Order updated and associated with the accepting user
                return $this->success(['loadBoard' => new LoadBoardResource($loadBoard)], 'Load accepted successfully');
            } else {
                // User who accepts the order not found
                return $this->success(null, 'User who accepts the order not found');

            }
        } else {
            // Order with the specified order number not found in load boards

            return $this->success(null, 'rder with the specified order number not found in load boards');

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

        $request->validated([
            "amount" => ['required','numeric'],
        ]);


        $acceptedLoad = $loadBoard->where('acceptable_id',"!=", null)->where("acceptable_type","!=",null)->first();

        if ($acceptedLoad) {
            return $this->error(null, 'This load has already been accepted by another driver.');
        }


        if($request->amount <= $loadBoard->order->amount){
            return $this->error(null, 'You can bid lower then amount');

        }

        $bid = Bid::create([
            'order_id' => $loadBoard->order->id,
            'driver_id' => auth()->id(),
            'amount' => $request->amount,
        ]);
        return new BidResource($bid);

    }

    public function getAllBidsByLoadBoard(LoadBoard $loadBoard)
{
    $bids = Bid::where('order_id', $loadBoard->order->id)->get();

    return BidResource::collection($bids);
}

}
