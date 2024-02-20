<?php

namespace Database\Seeders;

use App\Models\CarValuePrice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarValuePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $minRanges = [1000000, 5000001, 10000001, 15000001, 20000001, 25000001, 30000001, 35000001, 40000001, 45000001, 50000001, 55000001, 60000001, 65000001, 70000001, 75000001, 80000001, 85000001, 90000001, 95000001];
        $maxRanges = [5000000, 10000000, 15000000, 20000000, 25000000, 30000000, 35000000, 40000000, 45000000, 50000000, 55000000, 60000000, 65000000, 70000000, 75000000, 80000000, 85000000, 90000000, 95000000, 100000000];

        for ($i = 0; $i < count($minRanges); $i++) {
            CarValuePrice::create([
                'min' => $minRanges[$i],
                'max' => $maxRanges[$i],
                'price' => rand($minRanges[$i], $maxRanges[$i]),
                'status' => rand(0, 1) == 1 ? 'active' : 'inactive',
            ]);
        }
    }
}
