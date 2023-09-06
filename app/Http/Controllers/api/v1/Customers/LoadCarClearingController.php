<?php

namespace App\Http\Controllers\Api\v1\Customers;

use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Models\LoadCarClearing;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CarClearingRequest;

class LoadCarClearingController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;


    public function store(CarClearingRequest $request)
    {
        try {
            DB::beginTransaction();

            // Create a new car clearing record
            $carClearing = LoadCarClearing::create($request->validated());

            DB::commit();

            return $this->success($carClearing, 'Car clearing record created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error(null, 'Error creating Car Clearing', 500);
        }
    }


}
