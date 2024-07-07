<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\LocalState;
use App\Models\CarStatePrice;
use App\Models\CarCountryPrice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarStatePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $states = LocalState::all();

        $initialPrice = 10000;
        $maxPrice = 2000000;
        $incrementFactor = ($maxPrice - $initialPrice) / (Country::count() - Country::count()-2);

        foreach ($states as $state) {
        CarStatePrice::create([
            'state_id' => $state->id,
            'price' => $incrementFactor,
            'status' => 'active',
        ]);
    }
    }
}
