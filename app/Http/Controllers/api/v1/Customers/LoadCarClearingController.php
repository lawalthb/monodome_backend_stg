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


    public function index()
{
    try {
        $carClearingRecords = LoadCarClearing::all();

     //   return $this->success($carClearingRecords, 'Car clearing records retrieved successfully');


        $key = request()->input('search');
        $size = request()->input('size') ?? 20;

        $loadBulk = LoadCarClearing::where('user_id', auth()->id())->where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
                ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate($size);


        return LoadCarClearing::collection($loadBulk);


    } catch (\Exception $e) {
        return $this->error(null, 'Error fetching car clearing records', 500);
    }
}

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

    public function show($id)
{
    try {
        $carClearingRecord = LoadCarClearing::findOrFail($id);

        return $this->success($carClearingRecord, 'Car clearing record retrieved successfully');
    } catch (\Exception $e) {
        return $this->error(null, 'Car clearing record not found', 404);
    }
}



}
