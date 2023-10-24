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
                'name' => 'manage_roles',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'manage_permission',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'manage_users',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'approved_user',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'manage_order',
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
                'name' => 'manage_price',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            15 =>
            array (
                'id' => 16,
                'name' => 'manage_transaction',
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
                'name' => 'manage_notifications',
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
                'name' => 'manage_load_bulk',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            21 =>
            array (
                'id' => 22,
                'name' => 'manage_map',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'manage_load_type',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            23 =>
            array (
                'id' => 24,
                'name' => 'manage_vehicle',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            24 =>
            array (
                'id' => 25,
                'name' => 'manage_profile',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            25 =>
            array (
                'id' => 26,
                'name' => 'account_setting',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            26 =>
            array (
                'id' => 27,
                'name' => 'support_ticket',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            27 =>
            array (
                'id' => 28,
                'name' => 'manage_contact',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            28 =>
            array (
                'id' => 29,
                'name' => 'application_setting',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            29 =>
            array (
                'id' => 30,
                'name' => 'global_setting',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            30 =>
            array (
                'id' => 31,
                'name' => 'home_setting',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            31 =>
            array (
                'id' => 32,
                'name' => 'mail_configuration',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            32 =>
            array (
                'id' => 33,
                'name' => 'payment_option',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            33 =>
            array (
                'id' => 34,
                'name' => 'content_setting',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            34 =>
            array (
                'id' => 35,
                'name' => 'user_management',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            35 =>
            array (
                'id' => 36,
                'name' => 'manage_affiliate',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
           46 =>
            array (
                'id' => 47,
                'name' => 'manage_wallet_recharge',
                'guard_name' => 'api',
                'created_at' => '2022-12-01 02:48:19',
                'updated_at' => '2022-12-01 02:48:19',
            ),
            47 =>
            array (
                'id' => 48,
                'name' => 'create_blog',
                'guard_name' => 'api',
                'created_at' => '2022-12-01 02:48:19',
                'updated_at' => '2022-12-01 02:48:19',
            ),
            48 =>
            array (
                'id' => 49,
                'name' => 'menu_management',
                'guard_name' => 'api',
                'created_at' => '2022-12-01 02:48:19',
                'updated_at' => '2022-12-01 02:48:19',
            ),
            49 =>
            array (
                'id' => 50,
                'name' => 'policy_management',
                'guard_name' => 'api',
                'created_at' => '2022-12-01 02:48:19',
                'updated_at' => '2022-12-01 02:48:19',
            ),
            50 =>
            array (
                'id' => 51,
                'name' => 'blog_management',
                'guard_name' => 'api',
                'created_at' => '2022-12-01 02:48:19',
                'updated_at' => '2022-12-01 02:48:19',
            ),
        ));


    }
}
