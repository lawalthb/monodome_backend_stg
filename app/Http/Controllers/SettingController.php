<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;

class SettingController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    public function index()
    {
        $settings = Setting::all();
        return response()->json(['settings' => $settings]);


    }

     public function show($id)
    {
        $setting = Setting::find($id);

        if (!$setting) {
            return response()->json(['message' => 'Setting not found'], 404);
        }

        return response()->json(['setting' => $setting]);
    }
}
