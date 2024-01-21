<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TrucksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('trucks')->delete();

        \DB::table('trucks')->insert(array (
            0 =>
            array (
                'id' => 1,
                'uuid' => 'f4f4beb3-5a71-4edf-bb10-156cce22a48e',
                'business_name' => 'Buckinghamshire',
                'phone_number' => '070779873623',
                'street' => '980 Kari Stravenue',
                'user_id' => 22,
                'country_id' => NULL,
                'state_id' => 3,
                'lga' => '3',
                'truck_name' => 'Borders',
                'truck_type' => '1',
                'truck_location' => '9532 Mosciski Mills',
                'truck_make' => 'Janis.Marquardt84@gmail.com',
                'plate_number' => '86021355',
                'cac_number' => '55250549',
                'truck_description' => 'Shirt Spring card disintermediate',
                'profile_picture' => 'uploads/truck/truck_images/16986731663AiC0TUS8a.png',
                'outside_truck_picture' => NULL,
                'truck_document' => NULL,
                'status' => 'Pending',
                'created_at' => '2023-10-30 13:39:26',
                'updated_at' => '2023-10-30 13:39:26',
            ),
        ));


    }
}
