<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Agent;
use App\Models\Guarantor;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */

     public function run()
     {

        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'full_name' => 'super admin',
                'email' => 'admin@monodome.co',
                'phone_number' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$10$8LBMPVdIM97Sxh2q2diibeo/zvg40EWUe929AtVjuHZSi.NWvO1om',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'super_admin',
                'role' => NULL,
                'location' => NULL,
                'user_agent' => NULL,
                'status' => 'Pending',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:22:23',
                'updated_at' => '2023-10-30 13:22:23',
            ),
            1 =>
            array (
                'id' => 2,
                'full_name' => 'admin',
                'email' => 'admin@example.com',
                'phone_number' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$10$rmBJp3285EEP9N9gDVorN.oKJF/0gEEm25pCkrzRBWs3auEFT2Hk6',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'admin',
                'role' => NULL,
                'location' => NULL,
                'user_agent' => NULL,
                'status' => 'Pending',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:22:23',
                'updated_at' => '2023-10-30 13:22:23',
            ),
            2 =>
            array (
                'id' => 3,
                'full_name' => 'Customer',
                'email' => 'customer@gmail.com',
                'phone_number' => NULL,
                'email_verified_at' => NULL,
                'password' => '$2y$10$ls19QB7MfG39OL0BmrkLVuzgN1VbAyQ/UlkzIfGbWBCyu/5cFIfTG',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'customer',
                'role' => NULL,
                'location' => NULL,
                'user_agent' => NULL,
                'status' => 'Pending',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:22:23',
                'updated_at' => '2023-10-30 13:22:23',
            ),

        ));


         for ($i = 1; $i <= 20; $i++) {
             // Create a user
             $user = \App\Models\User::factory()->create([

                 'user_type' => "agent",
                 'role' => "agent",
                 'role_id' => 6,
             ]);

             // Create an agent and associate it with the user
             $agent = Agent::factory()->create([
                 'user_id' => $user->id,
             ]);

             $guarantor1 = Guarantor::factory()->create([
                'loadable_id' => $agent->id,
                'loadable_type' => 'App\\Models\\Agent',
            ]);

            $guarantor2 = Guarantor::factory()->create([
                'loadable_id' => $agent->id,
                'loadable_type' => 'App\\Models\\Agent',
            ]);

         }


     }

}
