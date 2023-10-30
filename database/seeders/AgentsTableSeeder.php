<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AgentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('agents')->delete();

        \DB::table('agents')->insert(array (
            0 =>
            array (
                'id' => 1,
                'uuid' => 'a6d42e20-3655-482f-be8b-c890b7dc0417',
                'agent_code' => '31870677',
                'user_id' => 20,
                'country_id' => NULL,
                'state_id' => 10,
                'street' => 'Myrtice Roads',
                'nin_number' => '34222444322',
                'lga' => '7',
                'business_name' => NULL,
                'phone_number' => '07011611144',
                'state_of_residence' => NULL,
                'city_of_residence' => NULL,
                'store_front_image' => 'uploads/agent/agent_images/1698672987H6I61xihIp.png',
                'inside_store_image' => 'uploads/agent/agent_images/1698672987x1VhK714G9.png',
                'registration_documents' => 'uploads/agent/agent_documents/1698672987e6eulgIV8a.pdf',
                'status' => 'Pending',
                'created_at' => '2023-10-30 13:36:27',
                'updated_at' => '2023-10-30 13:36:27',
                'deleted_at' => NULL,
            ),
        ));


    }
}
