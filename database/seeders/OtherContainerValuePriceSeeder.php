<?php

namespace Database\Seeders;

use App\Models\OtherContainerValuePrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OtherContainerValuePriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $minRanges = [10000, 50001, 100001, 150001, 200001, 250001, 300001, 350001, 400001, 450001, 500001, 550001, 600001, 650001, 700001, 750001, 800001, 850001, 900001, 950001];
        $maxRanges = [50000, 100000, 150000, 200000, 250000, 300000, 350000, 400000, 450000, 500000, 550000, 600000, 650000, 700000, 750000, 800000, 850000, 900000, 950000, 1000000];

        for ($i = 0; $i < count($minRanges); $i++) {
            OtherContainerValuePrice::create([
                'min' => $minRanges[$i],
                'max' => $maxRanges[$i],
                'price' => rand($minRanges[$i], $maxRanges[$i]),
                'status' => rand(0, 1) == 1 ? 'active' : 'inactive',
            ]);
        }
    }
}
