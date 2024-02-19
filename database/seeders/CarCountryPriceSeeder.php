<?php

namespace Database\Seeders;

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

        $countries = [
            'USA', 'Canada', 'Germany', 'France', 'Italy',
            'Japan', 'China', 'India', 'Brazil', 'Australia',
            'Russia', 'South Africa', 'Mexico', 'Spain', 'Netherlands',
            'Argentina', 'South Korea', 'Turkey', 'Saudi Arabia', 'United Kingdom'
        ];

        foreach ($countries as $country) {
            CarCountryPrice::create([
                'country' => $country,
                'price' => rand(1000000, 1000000),
                'status' => 'active',
            ]);
        }
    }
}
