<?php
namespace App\Http\Controllers\Api\v1\Customers;

use App\Models\LoadBulk;
use App\Models\LoadType;
use App\Models\LoadDocument;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Events\LoadTypeCreated;
use App\Models\LoadSpecialized;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadSpecializedRequest;
use App\Http\Resources\LoadSpecializedResource;

class LoadSpecializedController extends Controller
{

    use FileUploadTrait, ApiStatusTrait;



    public function index()
    {
        $key = request()->input('search');
        $size = request()->input('size') ?? 20;

        $loadBulk = LoadSpecialized::where('user_id', auth()->id())->where(function ($q) use ($key) {
            $q->where('load_type_name', 'like', "%{$key}%")
                ->orWhere('description', 'like', "%{$key}%");
        })->latest()->paginate($size);


        return LoadSpecializedResource::collection($loadBulk);
        // return response()->json($loadBulk);
    }



    public function store(LoadSpecializedRequest $request)
    {

        // Find the LoadType based on load_type_id
    $loadType = LoadType::find($request->load_type_id);

    if (!$loadType) {
        return response()->json(['message' => 'LoadType not found'], 404);
    }

    // Create a new LoadBulk instance with validated data
    $loadBulk = LoadSpecialized::updateOrCreate($request->validated());

    // Associate the LoadType
    $loadBulk->loadType()->associate($loadType);

    try {
        $loadBulk->save();

        if (!$loadBulk->order) {
            $order = $loadBulk->order()->create([
                'order_no' => getNumber(),
                'amount' => $request->total_amount,
                'user_id' => $loadBulk->user_id,
                'status' => "Pending",
            ]);
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
                "LoadSpecialized" => new LoadSpecializedResource($loadBulk),
            ],
            "Created Successfully",
        200);
    }
}
