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
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\PriceSettingResource;
use App\Http\Resources\DistanceSettingResource;

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
        $setting->slug = Str::camel($request->name);
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
         //   $setting->slug = Str::camel($request->name);
            $setting->save();
            return $setting;
        }else{
            return $this->error('','setting not found!',422);

        }
    }

    public function price(){

        return $this->success(
            [

                "settings" => PriceSettingResource::collection(PriceSetting::get())
            ],
            "price Settings"
        );
    }

    public function deletePrice(Request $request,$id){

       $price =  PriceSetting::findOrFail($id);

       if($price->delete()){

           return $this->success(
               null
               ,
               "price Settings delete"
            );
        }
    }


    public function deleteDistance(Request $request,$id){

        $distance =  DistanceSetting::findOrFail($id);

        if($distance->delete()){

            return $this->success(
                null
                ,
                "Distance Settings delete"
             );
         }
     }


    public function createPrice(Request $request){

        Validator::make($request->all(), [
            'name' => 'required|string',
            'load_type_id' => 'required|integer',
        ])->validate();

        $loadType=LoadType::find($request->load_type_id);

        $priceSetting = PriceSetting::updateOrCreate([
            'load_type_id'=>$loadType->id,
            'name'=>$request->name,
        ],[
            'load_type_id'=>$loadType->id,
            'name'=>$request->name,
        ]);

        return $this->success(
            [

                "settings" => new PriceSettingResource($priceSetting)
            ],
            "price Settings"
        );
    }

    public function distance()
    {
        $groupedDistanceSettings = DistanceSetting::with('loadable')
        ->get()
        ->groupBy(function ($item) {
            return $item->loadable->name; // Assuming 'name' is the attribute you want to group by
        });

    $result = [];
    foreach ($groupedDistanceSettings as $name => $settings) {
        $result[] = [
            'price_setting_name' => $name,
            'distance_settings' => DistanceSettingResource::collection($settings),
        ];
    }

    return response()->json([
        'success' => true,
        'message' => 'Distance settings grouped by Price Setting',
        'data' => $result,
    ]);
    }



    // public function distance(){

    //     return $this->success(

    //             DistanceSettingResource::collection(DistanceSetting::get())
    //         ,
    //         "Distance and price Settings"
    //     );
    // }


    public function storeDistance(Request $request)
    {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'weight' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
            'price' => 'required|numeric',
            'price_type_id' => 'required|numeric|exists:price_settings,id',
        ]);

        $priceSetting = PriceSetting::find($request->price_type_id);

        // Create or update the DistanceSetting record
        $distanceSetting = DistanceSetting::updateOrCreate(
            [
                'weight' => $request->weight,
                'from' => $request->from,
                'to' => $request->to,
                'loadable_id' => $priceSetting->id,
                'loadable_type' => PriceSetting::class,
            ],
            [
                'weight' => $request->weight,
                'from' => $request->from,
                'to' => $request->to,
                'loadable_id' => $priceSetting->id,
                'loadable_type' => PriceSetting::class,
                'price' => $request->price,
            ]
        );

        // Return a response indicating success
        return response()->json([
            'success' => true,
            'message' => 'DistanceSetting created or updated successfully',
            'data' => new DistanceSettingResource($distanceSetting),
        ], 201); // 201 Created status code
    }


    public function getDistancePricesByLoadType($loadTypeId)
    {
        $loadType = LoadType::findOrFail($loadTypeId);

        $distancePrices = $loadType->distancePrices;

        return response()->json(['distance_prices' => $distancePrices]);
    }



    public function getWeightPricesByLoadType($loadTypeId)
    {
        $loadType = LoadType::findOrFail($loadTypeId);

        $distancePrices = $loadType->weightPrices;

        return response()->json(['distance_prices' => $distancePrices]);
    }

}
