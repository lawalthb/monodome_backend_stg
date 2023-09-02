<?php

namespace App\Http\Controllers\api\v1\Customers;

use App\Models\LoadBulk;
use App\Models\LoadType;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadBulkRequest;
use App\Http\Resources\LoadBulkResource;

class LoadBulkController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {

        $key = request()->input('search');

        $loadBulk = LoadBulk::where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
            ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate();


       return LoadBulkResource::collection($loadBulk);
       // return response()->json($loadBulk);
    }

    public function show($id)
    {
        $loadBulk = LoadBulk::find($id);

        if (!$loadBulk) {
            return $this->error(null, "Load Bulk not found",404 );
        }
        return $this->success(["loadBulk" => new LoadBulkResource($loadBulk),], "Successfully");
    }

    public function store(LoadBulkRequest $request)
    {


   // dd($request->document);
        // Find the LoadType based on load_type_id
    $loadType = LoadType::find($request->load_type_id);

    if (!$loadType) {
        return response()->json(['message' => 'LoadType not found'], 404);
    }

    // Create a new LoadBulk instance with validated data
    $loadBulk = new LoadBulk($request->validated());

    // Associate the LoadType
    $loadBulk->loadType()->associate($loadType);

    // Handle document uploads (if any)
    if ($request->hasFile('documents')) {
        $documents = [];

        foreach ($request->file('documents') as $file) {
            $path = $file->store('load_documents'); // Adjust the storage path as needed

            // Create a record in the load_documents table
            $document = new LoadDocument([
                'name' => $file->getClientOriginalName(),
                'path' => $path,
            ]);

            $documents[] = $document;
        }

        // Associate the documents with the LoadBulk
        $loadBulk->loadDocuments()->saveMany($documents);
    }

    // Save the LoadBulk instance
    $loadBulk->save();

    return $this->success(
        [
            "loadBulk" => new LoadBulkResource($loadBulk),
        ],
        "Created Successfully"
    );

        // $loadType = LoadBulk::find($request->load_type_id);

        // $loadBulk = $loadType->loadBulk()->create($request->validated());

        // return $this->success(
        //     [
        //         "loadBulk" => new LoadBulkResource($loadBulk),
        //     ],
        //     "Created Successfully"
        // );
    }

    public function update(LoadBulkRequest $request, $id)
    {
        $loadType = LoadBulk::find($request->load_type_id);

        $loadBulk = $loadType->loadBulk()->create($request->validated());
        return $this->success(
            [
                "loadBulk" => new LoadBulkResource($loadBulk),
            ],
            "update Successfully"
        );
    }

    public function destroy($id)
    {
        $loadPackage = LoadBulk::find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found'",404 );
        }
        $loadPackage->delete();
        return $this->success(["loadType" => new LoadBulkResource($loadPackage),], "Package Type deleted");
    }

}
