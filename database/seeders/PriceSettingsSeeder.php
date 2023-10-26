<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PriceSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priceSettings = [
            [
                'name' => 'Packages',
            ],
            [
                'name' => 'Documents',
            ],
            [
                'name' => 'Bulk Delivery',
            ],
            [
                'name' => 'Car Clearing',
            ],
            [
                'name' => 'Container Clearing',
            ],
            [
                'name' => 'Car Delivery',
            ],
            [
                'name' => 'Container Delivery',
            ],

        ];

        DB::table('price_settings')->insert($priceSettings);
    }
}
