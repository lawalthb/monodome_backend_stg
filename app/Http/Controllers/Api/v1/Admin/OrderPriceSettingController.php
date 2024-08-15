<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Setting;
use App\Models\LoadType;
use Illuminate\Support\Str;
use App\Models\PriceSetting;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Models\DistanceSetting;
use App\Traits\FileUploadTrait;
use App\Models\OrderPriceSetting;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PriceSettingResource;
use App\Http\Resources\DistanceSettingResource;
use Illuminate\Http\Response;

class OrderPriceSettingController extends Controller
{

    use FileUploadTrait, ApiStatusTrait;
    public function index()
    {
        $settings = OrderPriceSetting::where('status', 'active')->get();

        return response()->json($settings);
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'price' => 'required|integer',
            'status' => 'required|in:active,inActive'
        ]);

        $setting = OrderPriceSetting::create($request->all());
        return response()->json($setting, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        $setting = OrderPriceSetting::find($id);
        if (!$setting) {
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json($setting);
    }

    public function update(Request $request, $id)
    {
        $setting = OrderPriceSetting::find($id);
        if (!$setting) {
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'price' => 'required|integer',
            'status' => 'required|in:active,inActive'
        ]);

        $setting->update($request->all());
        return response()->json($setting);
    }

    public function destroy($id)
    {
        $setting = OrderPriceSetting::find($id);

        if ($setting->is_default) {
            return response()->json(['message' => 'Default settings cannot be deleted.'], 403);
        }

        if (!$setting) {
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        $setting->delete();
        return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
    }

}
