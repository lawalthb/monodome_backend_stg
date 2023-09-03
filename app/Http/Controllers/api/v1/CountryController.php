<?php

namespace App\Http\Controllers\api\v1;

use App\Models\Country;
use App\Traits\ApiStatusTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\State;
use App\Traits\FileUploadTrait;

class CountryController extends Controller
{
    use ApiStatusTrait, FileUploadTrait;

    public function getCountry(Request $request)
    {
        $perPage = $request->input('per_page', 10); // Number of items per page, default is 10
        $query = Country::query();

        // Apply filters if provided in the request
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        if ($request->has('currency')) {
            $query->where('currency', 'like', '%' . $request->input('currency') . '%');
        }

        if ($request->has('currency_symbol')) {
            $query->where('currency_symbol', 'like', '%' . $request->input('currency_symbol') . '%');
        }

        $countries = $query->paginate($perPage);

        return $this->success($countries, "Countries retrieved successfully");
    }

    public function singleCountry($id){

        $country = Country::find($id);
        if (!$country) {
            return $this->error(null, "Country not found", 404);
        }
        return $this->success($country, "Country retrieved successfully");
    }


    public function getStatesByCountry(Request $request, $country_id)
    {
        $perPage = $request->input('per_page', 10); // Number of items per page, default is 10
        $query = State::where('country_id', $country_id)->with('country');

        // Apply filters if provided in the request
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Execute the query and paginate the results
        $states = $query->paginate($perPage);

        return $this->success($states, "States retrieved successfully");
    }


    public function getCitiesByCountryAndState(Request $request, $country_id,$state_id)
    {
        $perPage = $request->input('per_page', 10); // Number of items per page, default is 10
        $query = City::where('country_id', $country_id)->where('state_id', $state_id)->with('country');

        // Apply filters if provided in the request
        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->input('name') . '%');
        }

        // Execute the query and paginate the results
        $states = $query->paginate($perPage);

        return $this->success($states, "States retrieved successfully");
    }
}
