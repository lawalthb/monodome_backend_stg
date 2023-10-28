<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DistanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $fromDistance = 1;
        $toDistance = 50;
        $price = 120.00;
        $loadableId = 1; // You can set this based on your application logic
        $loadableType = 'load_packages';

        while ($toDistance <= 1000) { // Set your maximum distance here
            DB::table('distance_settings')->insert([
                [
                    'weight' => '0kg to 20kg',
                    'from' => $fromDistance . 'km',
                    'to' => $toDistance . 'km',
                    'price' => $price,
                    'loadable_id' => $loadableId,
                    'loadable_type' => $loadableType,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

            // Update values for the next record
            $fromDistance = $toDistance + 1;
            $toDistance += 50;
            $price += 30; // Adjust the price increment as needed
        }
    }
}
