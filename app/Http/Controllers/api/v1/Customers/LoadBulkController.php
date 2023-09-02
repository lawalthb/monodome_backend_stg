<?php

namespace App\Http\Controllers\api\v1\Customers;

use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\LoadBulkResource;
use App\Models\LoadBulk;

class LoadBulkController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {

        $key = request()->input('search');

        $loadPackages = LoadBulk::where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
            ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate();


       return LoadBulkResource::collection($loadPackages);
       // return response()->json($loadPackages);
    }

    public function show($id)
    {
        $loadPackage = LoadBulk::find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found",404 );
        }
        return $this->success(["loadPackage" => new LoadBulkResource($loadPackage),], "Successfully");
    }

    public function store(LoadBulkRequest $request)
    {
        $loadType=LoadBulk::find($request->load_type_id);

        $loadPackage = $loadType->loadPackages()->create($request->validated());

        return $this->success(
            [
                "loadPackage" => new LoadBulkResource($loadPackage),
            ],
            "Created Successfully"
        );
    }

    public function update(LoadPackageRequest $request, $id)
    {
        $loadType = LoadBulk::find($request->load_type_id);

        $loadPackage = $loadType->loadPackages()->create($request->validated());
        return $this->success(
            [
                "loadPackage" => new LoadBulkResource($loadPackage),
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
