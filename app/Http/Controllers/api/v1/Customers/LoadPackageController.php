<?php

namespace App\Http\Controllers\api\v1\Customers;

use App\Models\LoadPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadPackageRequest;
use App\Models\LoadType;

    class LoadPackageController extends Controller
{
    public function index()
    {

        $key = request()->input('search');

        $loadPackages = LoadPackage::where(function ($q) use ($key) {
            $q->where('name', 'like', "%{$key}%");
        })->latest()->paginate();


        return response()->json($loadPackages);
    }

    public function show($id)
    {
        $loadPackage = LoadPackage::find($id);
        if (!$loadPackage) {
            return response()->json(['message' => 'Load Package not found'], 404);
        }
        return response()->json($loadPackage);
    }

    public function store(LoadPackageRequest $request)
    {
        $loadType=LoadType::find($request->load_type_id);

        $loadPackage = $loadType->loadPackages()->create($request->validated());

        return response()->json($loadPackage, 201);
    }

    public function update(LoadPackageRequest $request, $id)
    {
        $loadType = LoadType::find($request->load_type_id);

        $loadPackage = $loadType->loadPackages()->create($request->validated());
        return response()->json($loadPackage, 201);
    }

    public function destroy($id)
    {
        $loadPackage = LoadPackage::find($id);
        if (!$loadPackage) {
            return response()->json(['message' => 'Load Package not found'], 404);
        }
        $loadPackage->delete();
        return response()->json(['message' => 'Load Package deleted']);
    }
}
