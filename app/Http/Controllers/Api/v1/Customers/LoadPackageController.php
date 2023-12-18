<?php
namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\Order;
use App\Models\LoadType;
use App\Models\LoadPackage;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Traits\FileUploadTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadPackageRequest;
use App\Http\Resources\LoadPackageResource;

    class LoadPackageController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;
    public function index()
    {

        $key = request()->input('search');

        $loadPackages = LoadPackage::where('user_id', auth()->id())->where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
            ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate();


       return LoadPackageResource::collection($loadPackages);
       // return response()->json($loadPackages);
    }

    public function show($id)
    {
        $loadPackage = LoadPackage::with('order')->find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found", 404);
        }

        return $this->success([
            "loadPackage" => new LoadPackageResource($loadPackage),
        ], "Successfully");
    }

    public function store(LoadPackageRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $loadType = LoadType::find($request->load_type_id);

            // Create a new LoadPackage instance
            // $loadPackage = $loadType->loadPackages()->create($request->validated());

            $loadPackage = LoadPackage::firstOrCreate(
                [
                    'load_type_id' => $request->load_type_id,
                    'user_id' => $request->user()->id ,
                    'total_amount' => $request->total_amount,
                    'weight' => $request->weight,
                ],
                $request->validated()
            );

            if (!$loadPackage->order) {
                // Create an associated Order if it doesn't exist
                $order = $loadPackage->order()->create([
                    'order_no' => getNumber(),
                  //  'driver_id' => 1, // Change this to the actual driver ID
                    'amount' => $request->total_amount, // Set the appropriate amount
                    'user_id' => $loadPackage->user_id,
                    'status' => "Pending",
                ]);
            } else {
                $order = $loadPackage->order; // If an order already exists, use the existing one
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
                $loadPackage->loadDocuments()->save($document);
            }
        }

            return $this->success([
                "loadPackage" => new LoadPackageResource($loadPackage),
                // "order" => $order, // Include the order in the response
            ], "Created Successfully");
        });
    }

    public function update(LoadPackageRequest $request, $id)
    {
        $loadType = LoadType::where('user_id', auth()->id())->find($request->load_type_id);

        $loadPackage = $loadType->loadPackages()->create($request->validated());
        return $this->success(
            [
                "loadPackage" => new LoadPackageResource($loadPackage),
            ],
            "update Successfully"
        );
    }

    public function destroy($id)
    {
        $loadPackage = LoadPackage::where('user_id', auth()->id())->find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found'",404 );
        }
        $loadPackage->delete();
        return $this->success(["loadType" => new LoadPackageResource($loadPackage),], "Package Type deleted");
    }
}
