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
        // Generate 20 random car year and price records
        for ($i = 0; $i < 20; $i++) {
            CarYearPrice::create([
                'year' => rand(2000, date('Y')),
                'price' => rand(1000, 10000),
                'status' => 'active',
        ]);
    }
}
}
