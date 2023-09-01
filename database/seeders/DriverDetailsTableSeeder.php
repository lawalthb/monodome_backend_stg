<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DriverDetailsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('driver_details')->delete();
        
        \DB::table('driver_details')->insert(array (
            0 => 
            array (
                'city_id' => 7,
                'city_of_resident' => 'ajah',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1,
                'lga' => 'alimosho',
                'licence_url' => '3',
                'license_number' => 'kys 341 xv',
                'name' => 'ali ayobami',
                'nin_number' => '455678995',
                'phone_number' => '0813224755',
                'profile_pic_url' => 'null',
                'state_id' => 6,
                'state_of_resident' => 'Ogun',
                'street' => 'alagbado street',
                'updated_at' => NULL,
                'user_id' => 8,
                'vehicle_img_url' => '1',
                'vehicle_type_id' => 5,
            ),
        ));
        
        
    }
}