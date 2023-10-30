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

        for ($i=1; $i <51 ; $i++) {


            \DB::table('users')->insert(array (
                0 =>
            array (
                'id' => 20+$i,
                'full_name' =>  fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'phone_number' => fake()->phoneNumber(),
                'email_verified_at' => NULL,
                'password' => '$2y$10$eY2s6Gk1vNKb443Xsl7qf.dQanjxEKoGg2b0h4XR1s9ghJmxycsw2',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'agent',
                'role' => NULL,
                'location' => NULL,
                'user_agent' => NULL,
                'status' => 'Pending',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:36:23',
                'updated_at' => '2023-10-30 13:36:23',
            ),
        ));

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


        \DB::table('guarantors')->insert(array (
            0 =>
            array (
                'id' => 15,
                'full_name' => 'Edgar Koch',
                'phone_number' => '79933322232',
                'email' => 'Lew.Oberbrunner38@example.org',
                'street' => '36930 Langworth Station',
                'state' => '294',
                'lga' => '1',
                'profile_picture' => 'uploads/agent/guarantor_images/169867298735N9rOhHWl.png',
                'state_of_residence' => NULL,
                'city_of_residence' => NULL,
                'loadable_id' => 1,
                'loadable_type' => 'App\\Models\\Agent',
                'created_at' => '2023-10-30 13:36:27',
                'updated_at' => '2023-10-30 13:36:27',
            ),
        ));
    }

    }
}
