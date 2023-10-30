<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ShippingCompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shipping_companies')->delete();
        
        \DB::table('shipping_companies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '555278af-339f-4fbb-9f91-c7e13163541d',
                'user_id' => 11,
                'state_id' => 23,
                'company_name' => 'katampe',
                'street' => 'Karley Inlet',
                'lga' => '3',
                'phone_number' => '0709464409',
                'nin_number' => '23422121111',
                'profile_picture' => 'uploads/shipping_company/agent_images/1698672547qlaiB2rgzP.png',
                'status' => 'Waiting',
                'created_at' => '2023-10-30 13:29:07',
                'updated_at' => '2023-10-30 13:29:07',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => 'd0a58ca1-ced5-4309-a554-cab48317b362',
                'user_id' => 12,
                'state_id' => 25,
                'company_name' => 'katampe',
                'street' => 'Breitenberg Land',
                'lga' => '3',
                'phone_number' => '0709464407',
                'nin_number' => '23422121111',
                'profile_picture' => 'uploads/shipping_company/agent_images/169867256158NWjMad5m.png',
                'status' => 'Waiting',
                'created_at' => '2023-10-30 13:29:21',
                'updated_at' => '2023-10-30 13:29:21',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => '43a6a593-72a8-4750-828a-17e253074a50',
                'user_id' => 13,
                'state_id' => 25,
                'company_name' => 'katampe',
                'street' => 'Camron Mews',
                'lga' => '3',
                'phone_number' => '07079464407',
                'nin_number' => '23442121111',
                'profile_picture' => 'uploads/shipping_company/agent_images/1698672585xZ7DAt1NCD.png',
                'status' => 'Waiting',
                'created_at' => '2023-10-30 13:29:45',
                'updated_at' => '2023-10-30 13:29:45',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}