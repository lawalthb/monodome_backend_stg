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
    // public function run()
    // {
    //     $fromDistance = 1;
    //     $toDistance = 50;
    //     $price = 10000.00;
    //    // $loadableId = 1; // You can set this based on your application logic
    //     $loadableType = 'App\Models\PriceSetting';

    //     while ($toDistance <= 1000) { // Set your maximum distance here
    //         $loadableId = mt_rand(1, 4);
    //         DB::table('distance_settings')->insert([
    //             [
    //                 'weight' => '0kg to 20kg',
    //                 'from' => $fromDistance,
    //                 'to' => $toDistance,
    //                 'price' => $price,
    //                 'loadable_id' => $loadableId,
    //                 'loadable_type' => $loadableType,
    //                 'created_at' => now(),
    //                 'updated_at' => now(),
    //             ]
    //         ]);

    //         // Update values for the next record
    //         $fromDistance = $toDistance + 1;
    //         $toDistance += 50;
    //         $price += 30; // Adjust the price increment as needed
    //     }
    // }

    public function run()
{
    $loadableType = 'App\Models\PriceSetting';

    for ($loadableId = 1; $loadableId <= 4; $loadableId++) {
        $fromDistance = 1;
        $toDistance = 100;
        $price = 1000.00;

        while ($toDistance <= 1000) {

            // $randomIncrement = [100, 200, 500][array_rand([100, 200, 500])];
            // $price += $randomIncrement;

            DB::table('distance_settings')->insert([
                [
                    'weight' => '0kg to 20kg',
                    'from' => $fromDistance,
                    'to' => $toDistance,
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
            $price += $toDistance; // Adjust the price increment as needed
        }
    }
}

}
