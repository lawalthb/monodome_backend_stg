<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('roles')->delete();

        DB::table('roles')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Super Admin',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),

            array (
                'id' => 2,
                'name' => 'admin',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),

            array (
                'id' => 3,
                'name' => 'Customer',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),

            array (
                'id' => 4,
                'name' => 'Broker',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),

            array (
                'id' => 5,
                'name' => 'Shipping Company',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),


            array (
                'id' => 6,
                'name' => 'Agent',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),

            array (
                'id' => 7,
                'name' => 'Clearing and Forwarding Agent',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),


            array (
                'id' => 8,
                'name' => 'Driver',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),


            array (
                'id' => 9,
                'name' => 'Driver Manager',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),

            array (
                'id' => 10,
                'name' => 'Company Transport',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),

            array (
                'id' => 11,
                'name' => 'Truck',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),

        ));


    }
}
