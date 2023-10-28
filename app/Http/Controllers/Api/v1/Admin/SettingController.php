<?php

namespace App\Http\Controllers\Api\v1\Admin;

use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ApiStatusTrait;
use App\Traits\FileUploadTrait;
use App\Http\Controllers\Controller;
use App\Models\PriceSetting;
use Illuminate\Support\Facades\Validator;

class SettingController extends Controller
{

    use FileUploadTrait, ApiStatusTrait;

    public function index(Request $request)
    {
        $key = $request->input('search');
        $perPage = $request->input('per_page', 10);

        $settings = Setting::where(function ($q) use ($key) {
            // Assuming there's a relationship between Agent and User
            $q->orWhere('value', 'like', "%{$key}%")->orWhere('slug', 'like', "%{$key}%");
        })
            ->latest()
            ->paginate($perPage);

            return $this->success(
                [
                    "settings" => $settings
                ],
                "Login Successfully"
            );
    }

    public function show(Request $request, $id){


        if (!is_numeric($id) || empty($id)) {
            return $this->error('', 'id must be a numeric value and cannot be empty', 422);
        }

        $setting = Setting::find($id);

        if( $setting){
            return $this->success(
                [

                    "settings" => $setting
                ],
                "Single Settings"
            );
        }else{
            return $this->error('','setting will following id not found!',422);

        }

    }

    public function delete(Request $request, $id){


        if (!is_numeric($id) || empty($id)) {
            return $this->error('', 'id must be a numeric value and cannot be empty', 422);
        }

        $setting = Setting::find($id);

        if( $setting){
            return $this->success(
               '',
                "setting deleted"
            );
        }else{
            return $this->error('','setting will following id not found!',422);

        }

    }

  public function store(Request $request){
        Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',
        ])->validate();

        $setting = new Setting;
        $setting->name = $request->name;
        $setting->value = $request->value;
        $setting->slug = Str::studly($request->name);
        $setting->save();
        return $setting;
    }

    public function update(Request $request, $id){
        Validator::make($request->all(), [
            'name' => 'required',
            'value' => 'required',
        ])->validate();

        if (!is_numeric($id) || empty($id)) {
            return $this->error('', 'id must be a numeric value and cannot be empty', 422);
        }

        $setting = Setting::find($id);

        if( $setting){

            $setting->name = $request->name;
            $setting->value = $request->value;
            $setting->slug = Str::studly($request->name);
            $setting->save();
            return $setting;
        }else{
            return $this->error('','setting not found!',422);

        }
    }

    public function price(){

        return $this->success(
            [

                "settings" => PriceSetting::get()
            ],
            "Single Settings"
        );
    }
}
