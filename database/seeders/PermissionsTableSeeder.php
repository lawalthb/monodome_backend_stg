<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('permissions')->delete();

        \DB::table('permissions')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'manage_order',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'manage_transaction',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'manage_price_settings',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'manage_statistics',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'manage_driver_manager',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'manage_agent',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'manage_driver',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'manage_customers',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'manage_broker',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'manage_shipping_company',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'manage_employee',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'manage_load_board',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'manage_admin',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'manage_wallet',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            14 =>
            array (
                'id' => 15,
                'name' => 'manage_website',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            15 =>
            array (
                'id' => 16,
                'name' => 'manage_specialized_shipment',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            16 =>
            array (
                'id' => 17,
                'name' => 'manage_transport_company',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            17 =>
            array (
                'id' => 18,
                'name' => 'manage_clear_forwarding_agent',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            18 =>
            array (
                'id' => 19,
                'name' => 'manage_private_load',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            19 =>
            array (
                'id' => 20,
                'name' => 'manage_blog',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            20 =>
            array (
                'id' => 21,
                'name' => 'support_ticket',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
        ));


    }
}
