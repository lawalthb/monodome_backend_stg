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

//     public function run()
// {
//     $loadableType = 'App\Models\PriceSetting';

//     for ($loadableId = 1; $loadableId <= 4; $loadableId++) {
//         $fromDistance = 1;
//         $toDistance = 100;
//         $price = 1000.00;

//         while ($toDistance <= 20000) {

//             // $randomIncrement = [100, 200, 500][array_rand([100, 200, 500])];
//             // $price += $randomIncrement;

//             DB::table('distance_settings')->insert([
//                 [
//                    // 'weight' => '0kg to 20kg',
//                     'min' => $fromDistance,
//                     'max' => $toDistance,
//                     'price' => $price,
//                     'loadable_id' => $loadableId,
//                     'loadable_type' => $loadableType,
//                     'created_at' => now(),
//                     'updated_at' => now(),
//                 ]
//             ]);

//             // Update values for the next record
//             $fromDistance = $toDistance + 1;
//             $toDistance += 50;
//             $price += $toDistance; // Adjust the price increment as needed
//         }
//     }
// }



public function run()
{


    $ranges = [
        ['min' => 100, 'max' => 300, 'price' => 2000, 'vehicle' => 'Car'],
        ['min' => 301, 'max' => 500, 'price' => 2000, 'vehicle' => 'Pick up'],
        ['min' => 501, 'max' => 1000, 'price' => 2000, 'vehicle' => 'Bus'],
        ['min' => 1001, 'max' => 2000, 'price' => 2000, 'vehicle' => '2 tons Bus'],
        ['min' => 2001, 'max' => 3000, 'price' => 2000, 'vehicle' => 'Canter'],
        ['min' => 25001, 'max' => 30000, 'price' => 2000, 'vehicle' => 'Trailer'],
    ];

    foreach ($ranges as $range) {
        $minWeight = $range['min'];
        $maxWeight = $range['max'];
        $vehicleDescription = $range['vehicle'];

        DB::table('weight_prices')->insert([
            'min_weight' => $minWeight,
            'max_weight' => $maxWeight,
            'price' => $range['price'],
            'vehicle_description' => $vehicleDescription,
            'load_type_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    DB::table('weight_prices')->insert([
        [
            'min_weight' => 100,
            'max_weight' => 300,
            'price' => 2000,
            'vehicle_description' => "Car",
            'load_type_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]
    ]);



    $loadTypeIds = [1, 6];
    $loadableType = 'App\Models\PriceSetting';

    foreach ($loadTypeIds as $loadTypeId) {
        $fromDistance = 1;
        $toDistance = 100;
        $price = 1000.00;

        while ($toDistance <= 20000) {

            // Seed data for distance_prices table
            DB::table('distance_prices')->insert([
                [
                    'min_km' => $fromDistance,
                    'max_km' => $toDistance,
                    'price' => $price,
                    'load_type_id' => $loadTypeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

            // Seed data for weight_prices table
            DB::table('weight_prices')->insert([
                [
                    'min_weight' => $fromDistance,
                    'max_weight' => $toDistance,
                    'price' => $price,
                   // 'desc' => fake()->word(),
                    'load_type_id' => $loadTypeId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ]);

            // Update values for the next record
            $fromDistance = $toDistance + 1;
            $toDistance += 200;
            $price += $toDistance; // Adjust the price increment as needed
        }
    }

}
}
