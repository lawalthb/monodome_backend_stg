<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\CarCountryPrice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarCountryPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $countries = Country::all();

        foreach ($countries as $country) {
        CarCountryPrice::create([
            'country' => $country->name,
            'price' => rand(10000, 1000000),
            'status' => 'active',
        ]);
    }
    }
}
