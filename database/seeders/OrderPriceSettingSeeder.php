<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderPriceSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        DB::table('order_price_settings')->insert([
            [
                'name' => 'First level',
                'level' => 'level_one',
                'percentage' => json_encode(["driver" => "80", "system" => "20"]),
                'status' => 'active',
            ],
            [
                'name' => 'Second level',
                'level' => 'level_two',
                'percentage' => json_encode(["clearing_and_forwarding" => "80", "system" => "20"]),
                'status' => 'active',
            ],
            [
                'name' => 'Third level',
                'level' => 'level_three',
                'percentage' => json_encode(["driver_manager" => "40", "driver" => "40", "system" => "20"]),
                'status' => 'active',
            ],
            [
                'name' => 'Fourth level',
                'level' => 'level_four',
                'percentage' => json_encode(["agent" => "20", "driver_manager" => "32", "driver" => "32", "system" => "16"]),
                'status' => 'active',
            ]
        ]);

    }

}
