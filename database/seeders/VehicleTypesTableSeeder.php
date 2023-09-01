<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VehicleTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vehicle_types')->delete();
        
        \DB::table('vehicle_types')->insert(array (
            0 => 
            array (
                'deleted_at' => NULL,
                'id' => 1,
                'name' => 'Hatchback',
            ),
            1 => 
            array (
                'deleted_at' => NULL,
                'id' => 2,
                'name' => 'Sedan',
            ),
            2 => 
            array (
                'deleted_at' => NULL,
                'id' => 3,
                'name' => 'MPV',
            ),
            3 => 
            array (
                'deleted_at' => NULL,
                'id' => 4,
                'name' => 'SUV',
            ),
            4 => 
            array (
                'deleted_at' => NULL,
                'id' => 5,
                'name' => 'Crossover',
            ),
            5 => 
            array (
                'deleted_at' => NULL,
                'id' => 6,
                'name' => 'Coupe',
            ),
            6 => 
            array (
                'deleted_at' => NULL,
                'id' => 7,
                'name' => 'Convertible',
            ),
        ));
        
        
    }
}