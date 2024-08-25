<?php
namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\OrderPriceSetting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class OrderPriceSettingController extends Controller
{
    public function index()
    {
        // Retrieve all active order price settings
        $settings = OrderPriceSetting::where('status', 'active')->get();

        return response()->json($settings);
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'percentage' => 'required|json',
            'status' => 'required|in:active,inActive'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Create a new order price setting
        $setting = OrderPriceSetting::create([
            'name' => $request->name,
            'level' => $request->level,
            'percentage' => $request->percentage,
            'status' => $request->status
        ]);

        return response()->json($setting, Response::HTTP_CREATED);
    }

    public function show($id)
    {
        // Find the specific order price setting by ID
        $setting = OrderPriceSetting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($setting);
    }

    public function update(Request $request, $id)
    {
        // Find the specific order price setting by ID
        $setting = OrderPriceSetting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
        }

        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'percentage' => 'required|json',
            'status' => 'required|in:active,inActive'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        // Update the existing order price setting
        $setting->update([
            'name' => $request->name,
            'level' => $request->level,
            'percentage' => $request->percentage,
            'status' => $request->status
        ]);

        return response()->json($setting);
    }

    public function destroy($id)
{
    // Find the specific order price setting by ID
    $setting = OrderPriceSetting::find($id);

    if (!$setting) {
        return response()->json(['message' => 'Not found'], Response::HTTP_NOT_FOUND);
    }

    // Prevent deletion of settings with IDs 1 to 4
    if (in_array($id, [1, 2, 3, 4])) {
        return response()->json(['message' => 'This setting cannot be deleted.'], Response::HTTP_FORBIDDEN);
    }

    if ($setting->is_default) {
        return response()->json(['message' => 'Default settings cannot be deleted.'], Response::HTTP_FORBIDDEN);
    }

    // Delete the order price setting
    $setting->delete();

    return response()->json(['message' => 'Deleted successfully'], Response::HTTP_OK);
}

}
