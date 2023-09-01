<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoadTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('load_types')->delete();
        
        \DB::table('load_types')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'package',
                'is_active' => 'Yes',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'bulk',
                'is_active' => 'Yes',
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'car clearing',
                'is_active' => 'Yes',
            ),
            3 => 
            array (
                'id' => 4,
                'name' => 'container shipment',
                'is_active' => 'Yes',
            ),
            4 => 
            array (
                'id' => 5,
                'name' => 'specialize shipment',
                'is_active' => 'Yes',
            ),
        ));
        
        
    }
}