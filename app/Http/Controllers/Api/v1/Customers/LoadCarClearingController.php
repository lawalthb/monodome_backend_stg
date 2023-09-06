<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\LoadType;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Models\LoadCarClearing;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\CarClearingRequest;
use App\Http\Resources\LoadCarClearingResource;

class LoadCarClearingController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;


    public function index()
{
    try {

        $key = request()->input('search');
        $size = request()->input('size') ?? 20;

      //  return auth()->id();
        $loadBulk = LoadCarClearing::where('user_id', auth()->id())->where(function ($q) use ($key) {
            $q->where('car_value', 'like', "%{$key}%")
            ->orWhere('receiver_name', 'like', "%{$key}%")
                ->orWhere('car_year', 'like', "%{$key}%");
        })->latest()->paginate($size);


        return $loadBulk;
        return LoadCarClearingResource::collection($loadBulk);


    } catch (\Exception $e) {
        return $this->error(null, 'Error fetching car clearing records', 500);
    }
}

    public function store(CarClearingRequest $request)
    {
        try {
            DB::beginTransaction();

            // Find the LoadType based on load_type_id
            $loadType = LoadType::find($request->load_type_id);

            if (!$loadType) {
                return response()->json(['message' => 'LoadType not found'], 404);
            }

            // Create a new car clearing record
            $carClearing = LoadCarClearing::create($request->validated());

              // Associate the LoadType
             $carClearing->loadType()->associate($loadType);

                   // Handle document uploads (if any)
        if ($request->hasFile('documents')) {
            $documents = [];
            foreach ($request->file('documents') as $file) {

                $file = $this->uploadFileWithDetails('load_documents', $file);
                $path = $file['path'];
                $name = $file['file_name'];

                // Create a record in the load_documents table
                $document = new LoadDocument([
                    'name' => $name,
                    'path' => $path,
                ]);

                // Associate the document with the LoadBulk
                $carClearing->loadDocuments()->save($document);
            }
        }
        event(new LoadTypeCreated($carClearing));

            DB::commit();

            return $this->success( new LoadCarClearingResource($carClearing) , 'Car clearing record created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return $this->error($e->getMessage(), 'Error creating Car Clearing', 500);
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
