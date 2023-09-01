<?php

namespace App\Http\Controllers\api\v1\Customers;

use App\Models\LoadPackage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoadPackageRequest;

    class LoadPackageController extends Controller
{
    public function index()
    {
        $loadPackages = LoadPackage::all();
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
        $loadPackage = LoadPackage::create($request->validated());
        return response()->json($loadPackage, 201);
    }

    public function update(LoadPackageRequest $request, $id)
    {
        $loadPackage = LoadPackage::find($id);
        if (!$loadPackage) {
            return response()->json(['message' => 'Load Package not found'], 404);
        }
        $loadPackage->update($request->validated());
        return response()->json($loadPackage);
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
