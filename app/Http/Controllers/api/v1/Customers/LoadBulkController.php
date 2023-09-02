<?php

namespace App\Http\Controllers\api\v1\Customers;

use App\Models\LoadBulk;
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
        $loadType=LoadBulk::find($request->load_type_id);

        $loadBulk = $loadType->loadBulk()->create($request->validated());

        return $this->success(
            [
                "loadBulk" => new LoadBulkResource($loadBulk),
            ],
            "Created Successfully"
        );
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
