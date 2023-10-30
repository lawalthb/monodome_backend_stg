<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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

        $roles = Role::all();

        foreach ($roles as $role) {
            // Adjust this number based on how many users you want for each role
            $userCount = 50;

            User::factory($userCount)->create([
                'role_id' => $role->id,
            ]);
        }
    }
}
