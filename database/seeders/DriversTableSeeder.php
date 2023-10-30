<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DriversTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('drivers')->delete();
        
        \DB::table('drivers')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '11ddf567-fa1f-4bc6-a0dd-e717bcc6b5c3',
                'user_id' => 4,
                'state_id' => 29,
                'type' => 'driver',
                'have_motor' => 'Yes',
                'street' => 'Ferne Passage',
                'lga' => '3',
                'nin_number' => '2933333337',
                'license_number' => '23321112232',
                'proof_of_license' => 'uploads/driver/driver_images/1698672302vTahCgQgJi.png',
                'vehicle_type_id' => 3,
                'profile_picture' => 'uploads/driver/driver_images/1698672302HeShyrRjzy.png',
                'status' => 'Pending',
                'created_at' => '2023-10-30 13:25:02',
                'updated_at' => '2023-10-30 13:25:02',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => '4a58c640-49c1-4ff6-8398-80f9d70ebfb3',
                'user_id' => 5,
                'state_id' => 29,
                'type' => 'driver',
                'have_motor' => 'Yes',
                'street' => 'Powlowski Skyway',
                'lga' => '3',
                'nin_number' => '2933333337',
                'license_number' => '23321112232',
                'proof_of_license' => 'uploads/driver/driver_images/1698672322Vxs46mgqML.png',
                'vehicle_type_id' => 3,
                'profile_picture' => 'uploads/driver/driver_images/1698672322uvKdJTaYiZ.png',
                'status' => 'Pending',
                'created_at' => '2023-10-30 13:25:22',
                'updated_at' => '2023-10-30 13:25:22',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => '7b98ee88-3067-4cdc-8ed1-ad259d4d60f0',
                'user_id' => 6,
                'state_id' => 29,
                'type' => 'driver',
                'have_motor' => 'Yes',
                'street' => 'Triston Spring',
                'lga' => '3',
                'nin_number' => '2933333337',
                'license_number' => '23321112232',
                'proof_of_license' => 'uploads/driver/driver_images/1698672329RSABEptnCv.png',
                'vehicle_type_id' => 3,
                'profile_picture' => 'uploads/driver/driver_images/1698672329x9Y3nTtsHT.png',
                'status' => 'Pending',
                'created_at' => '2023-10-30 13:25:29',
                'updated_at' => '2023-10-30 13:25:29',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'uuid' => 'cb1608cc-3cc9-48bf-8960-27ca7d9e7f23',
                'user_id' => 7,
                'state_id' => 29,
                'type' => 'driver',
                'have_motor' => 'No',
                'street' => 'Doyle Trafficway',
                'lga' => '3',
                'nin_number' => '2933333337',
                'license_number' => '23321112232',
                'proof_of_license' => 'uploads/driver/driver_images/1698672342EijNv4zVIw.png',
                'vehicle_type_id' => 3,
                'profile_picture' => 'uploads/driver/driver_images/1698672342IZV7I3FaGZ.png',
                'status' => 'Pending',
                'created_at' => '2023-10-30 13:25:42',
                'updated_at' => '2023-10-30 13:25:42',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'uuid' => '878a3971-d6c6-46f7-8b25-42cb796898cf',
                'user_id' => 8,
                'state_id' => 23,
                'type' => 'driver',
                'have_motor' => 'No',
                'street' => 'Nigel Flat',
                'lga' => '4',
                'nin_number' => '2933333337',
                'license_number' => '23321112232',
                'proof_of_license' => 'uploads/driver/driver_images/1698672359cWoTWXp99n.png',
                'vehicle_type_id' => 3,
                'profile_picture' => 'uploads/driver/driver_images/1698672359svKZdelaML.png',
                'status' => 'Pending',
                'created_at' => '2023-10-30 13:25:59',
                'updated_at' => '2023-10-30 13:25:59',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}