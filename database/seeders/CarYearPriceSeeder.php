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
        for ($i = 0; $i < 20; $i++) {
            CarYearPrice::create([
                'year' => rand(2000, date('Y')),
                'price' => rand(100000, 2000000),
                'status' => 'active',
            ]);
        }

    }
}
}
