<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\LoadType;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Models\LoadContainer;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoadContainerResource;
use App\Http\Requests\LoadContainerShipmentRequest;

class LoadContainerController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;


    public function index()
    {
        try {

            $key = request()->input('search');
            $size = request()->input('size') ?? 20;

          //  return auth()->id();
            $loadBulk = LoadContainer::where('user_id', auth()->id())->where(function ($q) use ($key) {
                $q->where('container_height', 'like', "%{$key}%")
                ->orWhere('receiver_name', 'like', "%{$key}%")
                    ->orWhere('container_value', 'like', "%{$key}%");
            })->latest()->paginate($size);


         //   return $loadBulk;
            return LoadContainerResource::collection($loadBulk);


        } catch (\Exception $e) {
            return $this->error(null, 'Error fetching Container Shipment records', 500);
        }
    }

        public function store(LoadContainerShipmentRequest $request)
        {
            try {
                DB::beginTransaction();

                // Find the LoadType based on load_type_id
                $loadType = LoadType::find($request->load_type_id);

                if (!$loadType) {
                    return response()->json(['message' => 'LoadType not found'], 404);
                }

                // Create a new Container Shipment record
                $carClearing = LoadContainer::create($request->validated());

                  // Associate the LoadType
                 $carClearing->loadType()->associate($loadType);


                       // Handle document uploads (if any)
                       if (!$carClearing->order) {
                        $order = $carClearing->order()->create([
                            'order_no' => getNumber(),
                            'driver_id' => 1,
                            'amount' => $request->total_amount,
                            'user_id' => $carClearing->user_id,
                            'status' => "Pending",
                        ]);
                    }

            if ($request->input('documents')  && count($request->file('documents')) == count($request->input('documents'))) {

                foreach ($request->input('documents') as $key => $fileData) {

                    $file = $this->uploadFileWithDetails('load_documents', $request->file("documents.$key.file"));
                    $path = $file['path'];
                    $name = $fileData['document_type'];//$file['file_name'];

                    // Create a record in the load_documents table
                    $document = new LoadDocument([
                        'name' => $name,
                        'path' => $path,
                    ]);

                    // Associate the document with the LoadBulk
                    $carClearing->loadDocuments()->save($document);
                }
            }else{
                return $this->error("Number of document files should equals to number of document name", 'Error creating Container Shipment', 500);

            }
            //event(new LoadTypeCreated($carClearing));

                DB::commit();

                return $this->success( new LoadContainerResource($carClearing) , 'Container Shipment record created successfully');
            } catch (\Exception $e) {
                DB::rollBack();

                return $this->error($e->getMessage(), 'Error creating Container Shipment', 500);
            }
        }

        public function show($id)
    {
        try {
            $carClearingRecord = LoadContainer::findOrFail($id);

            return $this->success($carClearingRecord, 'Container Shipment record retrieved successfully');
        } catch (\Exception $e) {
            return $this->error(null, 'Container Shipment record not found', 404);
        }
    }


}
