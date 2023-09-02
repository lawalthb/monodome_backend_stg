<?php

namespace App\Http\Controllers\api\v1\Customers;

use App\Models\LoadType;
use App\Models\LoadPackage;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadPackageRequest;
use App\Http\Resources\LoadPackageResource;

    class LoadPackageController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;
    public function index()
    {

        $key = request()->input('search');

        $loadPackages = LoadPackage::where(function ($q) use ($key) {
            $q->where('sender_name', 'like', "%{$key}%")
            ->orWhere('sender_email', 'like', "%{$key}%");
        })->latest()->paginate();


       return LoadPackageResource::collection($loadPackages);
       // return response()->json($loadPackages);
    }

    public function show($id)
    {
        $loadPackage = LoadPackage::find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found",404 );
        }
        return $this->success(["loadPackage" => new LoadPackageResource($loadPackage),], "Successfully");
    }

    public function store(LoadPackageRequest $request)
    {
        $loadType=LoadType::find($request->load_type_id);

        $loadPackage = $loadType->loadPackages()->create($request->validated());

        return $this->success(
            [
                "loadPackage" => new LoadPackageResource($loadPackage),
            ],
            "Created Successfully"
        );
    }

    public function update(LoadPackageRequest $request, $id)
    {
        $loadType = LoadType::find($request->load_type_id);

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
        $loadPackage = LoadPackage::find($id);

        if (!$loadPackage) {
            return $this->error(null, "Load Package not found'",404 );
        }
        $loadPackage->delete();
        return $this->success(["loadType" => new LoadPackageResource($loadPackage),], "Package Type deleted");
    }
}
