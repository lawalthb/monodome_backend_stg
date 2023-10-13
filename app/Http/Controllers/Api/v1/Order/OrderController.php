<?php

namespace App\Http\Controllers\Api\v1\Order;

use App\Models\Order;
use App\Models\LoadType;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;

class OrderController extends Controller
{
    use ApiStatusTrait;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(OrderRequest $request)
    {
        $loadType = LoadType::find($request->load_type_id);

        if(!$loadType){

            return $this->error('','LoadType not found', 404);
        }

        $specificType = $loadType->specificType; // This will return the related specific type (Package, Bulk, Container, or CarClearing)

        if (!$specificType) {
            return $this->error('', 'Specific type not found', 404);
        }

        //this get load to pay
       $load = $specificType->where('id', $request->load_id)->first();

        if (!$load) {
            return $this->error('', 'Load not found', 404);
        }

        if(!$load->user->wallet){
            return $this->error('', 'wallet not setup', 404);

        }

            $loadTotalAmount = number_format($load->total_amount, 2, '.', ''); // Format as a string with 2 decimal places
            $userWalletAmount = number_format($load->user->wallet->amount, 2, '.', '');

            if ($userWalletAmount < $loadTotalAmount ) {
                return $this->error('', 'Insufficient funds in wallet!', 404);
            }


        $load->user->wallet->amount -= $loadTotalAmount;

         $order = new Order;
         $order->order_no = getNumber();
         $order->driver_id = 1;
         $order->amount = $loadTotalAmount;
         $order->user_id = $load->user_id;
         $order->status = "Paid";
         $order->loadable()->associate($load);

         if($order->save()){

            event(new LoadTypeCreated($load));

            return $this->success( new OrderResource($order) , 'Car clearing record created successfully');


         }else{

            return $this->error([], 'Error placing other', 500);

         }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
