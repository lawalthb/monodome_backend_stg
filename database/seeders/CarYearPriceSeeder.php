<?php

namespace Database\Seeders;

use App\Models\CarYearPrice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarYearPriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $startYear = 1990;
        $endYear = 2024;
        $initialPrice = 100000;
        $maxPrice = 2000000;
        $incrementFactor = ($maxPrice - $initialPrice) / ($endYear - $startYear);

        for ($i = $startYear; $i <= $endYear; $i++) {
            $price = $initialPrice + ($i - $startYear) * $incrementFactor;

            CarYearPrice::create([
                'year' => $i,
                'price' => $price,
                'status' => 'active',
            ]);
        }
    }

}
