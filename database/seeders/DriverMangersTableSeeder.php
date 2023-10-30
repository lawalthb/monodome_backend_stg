<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DriverMangersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('driver_mangers')->delete();
        
        \DB::table('driver_mangers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '59e4b415-cb50-4834-b63e-6aedb50b1e8f',
                'user_id' => 21,
                'country_id' => NULL,
                'state_id' => 10,
                'lga' => '7',
                'business_name' => 'Robin Terry',
                'email' => NULL,
                'phone_number' => '070642364315',
                'street' => 'Judah Manors',
                'state_of_residence' => NULL,
                'city_of_residence' => NULL,
                'office_front_image' => 'uploads/driver_manager/1698673081GVIKmVAmNL.png',
                'inside_office_image' => 'uploads/driver_manager/1698673081V93V5B2J9a.jpg',
                'registration_documents' => NULL,
                'cac_certificate' => 'uploads/driver_manager/1698673081KCDTad5tge.png',
                'status' => 'Pending',
                'created_at' => '2023-10-30 13:38:01',
                'updated_at' => '2023-10-30 13:38:01',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}