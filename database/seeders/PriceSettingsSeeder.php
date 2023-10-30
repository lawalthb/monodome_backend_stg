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
                'load_type_id'=>1
            ],
            [
                'name' => 'Documents',
                'load_type_id'=>1
            ],
            [
                'name' => 'Bulk Delivery',
                'load_type_id'=>2
            ],
            [
                'name' => 'Car Clearing',
                'load_type_id'=>3
            ],
            [
                'name' => 'Container Clearing',
                'load_type_id'=>4
            ],
            [
                'name' => 'Car Delivery',
                'load_type_id'=>3
            ],
            [
                'name' => 'Container Delivery',
                'load_type_id'=>4
            ],

        ];

        DB::table('price_settings')->insert($priceSettings);
    }
}
