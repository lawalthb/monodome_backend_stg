<?php

namespace App\Http\Controllers\Api\v1\Order;

use App\Models\Order;
use App\Models\LoadType;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Http\Requests\OrderRequest;
use App\Http\Controllers\Controller;

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

       // return $load;

        $order = new Order;

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
