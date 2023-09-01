<?php

namespace App\Http\Controllers\api\v1\Customers;

use App\Models\LoadType;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadTypeRequest;
use App\Http\Resources\LoadTypeResource;

class LoadTypeController extends Controller
{
    use FileUploadTrait, ApiStatusTrait;

    public function index()
    {
        $key = request()->input('search');

        $loadTypes = LoadType::where(function ($q) use ($key) {
            $q->where('name', 'like', "%{$key}%");
        })->latest()->paginate();

        return LoadTypeResource::collection($loadTypes);
        // return response()->json(["data"=>LoadTypeResource::collection($loadTypes)]);
    }

    public function show($id)
    {
        $loadType = LoadType::find($id);
        if (!$loadType) {
            return $this->error(null, "Load Type not found",404 );
        }
        return $this->success(["loadType" => new LoadTypeResource($loadType),], "Successfully");

    }

    public function store(LoadTypeRequest $request)
    {


        $loadType = LoadType::create($request->validated());

        return $this->success(
            [
                "loadType" => new LoadTypeResource($loadType),
            ],
            "Successfully"
        );
       // return response()->json($loadType, 201);
    }

    public function update(LoadTypeRequest $request, $id)
    {
        $loadType = LoadType::find($id);
        if (!$loadType) {
            return response()->json(['message' => 'Load Type not found'], 404);
        }
        $loadType->update($request->validated());
        return response()->json($loadType);
    }

    public function destroy($id)
    {
        $loadType = LoadType::find($id);
        if (!$loadType) {
            return response()->json(['message' => 'Load Type not found'], 404);
        }
        $loadType->delete();
        return response()->json(['message' => 'Load Type deleted']);
    }
}
