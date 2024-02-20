<?php

namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\LoadBulk;
use App\Models\LoadType;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadBulkRequest;
use App\Http\Resources\LoadBulkResource;

class LoadBulkController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {
        $key = request()->input('search');
        $size = request()->input('size') ?? 20;

        $loadBulk = LoadBulk::where('user_id', auth()->id())->where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
                ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate($size);


        return LoadBulkResource::collection($loadBulk);
        // return response()->json($loadBulk);
    }

    public function show($id)
    {
        $loadBulk = LoadBulk::where('user_id', auth()->id())->find($id);

        if (!$loadBulk) {
            return $this->error(null, "Load Bulk not found", 404);
        }
        return $this->success(["loadBulk" => new LoadBulkResource($loadBulk),], "Successfully");
    }

    public function store(LoadBulkRequest $request)
    {

    $loadType = LoadType::find($request->load_type_id);

    if (!$loadType) {
        return response()->json(['message' => 'LoadType not found'], 404);
    }
    $validatedData = $request->validated();

    $totalAmount = $validatedData['delivery_fee'] + $validatedData['insure_amount'];


   // $loadBulk = LoadBulk::updateOrCreate($request->validated());

    $loadBulk = LoadBulk::firstOrCreate(
        [
            'load_type_id' => $request->load_type_id,
            'user_id' => $request->user()->id ,
            'delivery_fee' => $request->delivery_fee,
            'weight' => $request->weight,
        ],
        array_merge($validatedData, ['total_amount' => $totalAmount])
    );

    $loadBulk->loadType()->associate($loadType);

    try {
        $loadBulk->save();


        if (!$loadBulk->order) {

            $order = $loadBulk->order()->create([
                'order_no' => getNumber(),
                //'driver_id' => 1,
                'amount' =>  $totalAmount,
                'fee' =>  $validatedData['delivery_fee'],
                'user_id' => $loadBulk->user_id,
               // 'status' => "Pending",
            ]);
            
        } else {
            $order = $loadBulk->order;
        }


    } catch (\Exception $e) {
        // Handle the error here
        return response()->json(['message' => 'Error creating LoadBulk', 'error' => $e->getMessage()], 500);
    }

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
                $loadBulk->loadDocuments()->save($document);
            }
        }
        //event(new LoadTypeCreated($loadBulk));

        return $this->success(
            [
                "loadBulk" => new LoadBulkResource($loadBulk),
            ],
            "Created Successfully"
        );
    }

    public function update(LoadBulkRequest $request, LoadBulk $loadBulk)
{
    // Find the LoadType based on load_type_id
    $loadType = LoadType::find($request->load_type_id);

    if (!$loadType) {
        return response()->json(['message' => 'LoadType not found'], 404);
    }

    // Update the LoadBulk instance with validated data
    $loadBulk->fill($request->validated());

    // Associate the updated LoadType
    $loadBulk->loadType()->associate($loadType);

    // Save the updated LoadBulk instance
    try {
        $loadBulk->save();
    } catch (\Exception $e) {
        // Handle the error here
        return response()->json(['message' => 'Error updating LoadBulk', 'error' => $e->getMessage()], 500);
    }
    $loadDocuments = $loadBulk->loadDocuments;
    // Handle document uploads (if any)
    if ($request->hasFile('documents')) {
        $documents = [];
       // Log::info( $loadDocuments);
        foreach ($loadDocuments as $loadDocument) {
           // Log::info($loadDocument->path);
            $this->deleteFile($loadDocument->path);
            $loadDocument->delete();
        }

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
            $loadBulk->loadDocuments()->save($document);
        }
    }

    return $this->success(
        [
            "loadBulk" => new LoadBulkResource($loadBulk),
        ],
        "Updated Successfully"
    );
}

    public function destroy($id)
    {
        $loadBulk = LoadBulk::where('user_id', auth()->id())->find($id);

    if (!$loadBulk) {
        return $this->error(null, "LoadBulk not found'", 404);
    }

    // Delete associated LoadDocument records
    $loadBulk->loadDocuments()->delete();

    // Delete the LoadBulk record
    $loadBulk->delete();

    return $this->success(null, "LoadBulk and associated LoadDocuments deleted");
    }

    public function delivery_fee(Request $request, LoadBulk $loadBulk){

        $loadBulk->delivery_fee += $request->increase_amount;
        $loadBulk->total_amount += $request->increase_amount;

        if($loadBulk->save()){
            $loadBulk->order->fee = $loadBulk->delivery_fee;
            $loadBulk->order->amount = $loadBulk->total_amount;
            $loadBulk->order->save();

            $fields = [
                'email' => $loadBulk->user->email,
                'amount' => str_pad($loadBulk->total_amount, 2, '0', STR_PAD_RIGHT),
            ];

            // call the paystack api
            $result = payStack_checkout($fields);

            return $this->success([
                "paystack" => $result->data,
                "loadBulk" => new LoadBulkResource($loadBulk),
            ], "Successfully");

        }else{

            return $this->error(null, "unable to update delivery fee", 404);

        }
}

}
