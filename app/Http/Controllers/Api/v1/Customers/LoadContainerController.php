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
                $carContainer = LoadContainer::create($request->validated());
                $carsInContainer = json_decode($request->cars_in_container, true);
                $otherInContainer = json_decode($request->other_contents_in_container, true);

                $totalAmount = 0;

                if (is_array($carsInContainer)) {
                    foreach ($carsInContainer as $car) {
                        $totalAmount += $car['amount'] ?? 0;
                    }


                    foreach ($otherInContainer as $other) {
                        $totalAmount += $other['amount'] ?? 0;
                    }

                    // Assign total amount to the 'container_value' attribute
                    $carContainer->container_value = $totalAmount;
                    $carContainer->save();

                } else {
                    throw new \Exception('Invalid format for cars in container data');
                }

                // $totalAmount = 0;
                // foreach (json_decode( $request->cars_in_container) as $car) {
                //     $totalAmount += $car['amount'];
                // }

                // $carContainer->container_value = $totalAmount;
                // $carContainer->save();


                  // Associate the LoadType
                 $carContainer->loadType()->associate($loadType);


                       // Handle document uploads (if any)
                       if (!$carContainer->order) {
                        $order = $carContainer->order()->create([
                            'order_no' => getNumber(),
                            'driver_id' => 1,
                            'amount' => $request->total_amount,
                            'user_id' => $carContainer->user_id,
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
                    $carContainer->loadDocuments()->save($document);
                }
            }else{
                return $this->error("Number of document files should equals to number of document name", 'Error creating Container Shipment', 500);

            }
            //event(new LoadTypeCreated($carContainer));

                DB::commit();

                return $this->success( new LoadContainerResource($carContainer) , 'Container Shipment record created successfully');
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
