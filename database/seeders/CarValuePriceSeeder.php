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
        // Seed 20 random records
        for ($i = 0; $i < 20; $i++) {
            CarValuePrice::create([
                'min_amount' => rand(1000, 10000),
                'max_amount' => rand(10000, 10000),
                'price' => rand(100000, 1000000),
                'status' => rand(0, 1) == 1 ? 'active' : 'inactive',
            ]);
        }
    }
}
