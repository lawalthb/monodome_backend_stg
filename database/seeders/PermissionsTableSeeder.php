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
                'name' => 'manage_course',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'pending_course',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'hold_course',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'approved_course',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'all_course',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'manage_course_reference',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'manage_course_category',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'manage_course_subcategory',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'manage_course_tag',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'manage_course_language',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'manage_course_difficulty_level',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'manage_instructor',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'pending_instructor',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'approved_instructor',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            14 =>
            array (
                'id' => 15,
                'name' => 'all_instructor',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            15 =>
            array (
                'id' => 16,
                'name' => 'add_instructor',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            16 =>
            array (
                'id' => 17,
                'name' => 'manage_student',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            17 =>
            array (
                'id' => 18,
                'name' => 'manage_coupon',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            18 =>
            array (
                'id' => 19,
                'name' => 'manage_promotion',
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
                'name' => 'payout',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            21 =>
            array (
                'id' => 22,
                'name' => 'finance',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'manage_certificate',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            23 =>
            array (
                'id' => 24,
                'name' => 'ranking_level',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            24 =>
            array (
                'id' => 25,
                'name' => 'manage_language',
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
            36 =>
            array (
                'id' => 37,
                'name' => 'manage_subscriptions',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            37 =>
            array (
                'id' => 38,
                'name' => 'manage_saas',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            38 =>
            array (
                'id' => 39,
                'name' => 'manage_organization',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            39 =>
            array (
                'id' => 40,
                'name' => 'pending_organization',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            40 =>
            array (
                'id' => 41,
                'name' => 'approved_organization',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            41 =>
            array (
                'id' => 42,
                'name' => 'all_organization',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            42 =>
            array (
                'id' => 43,
                'name' => 'add_organization',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            43 =>
            array (
                'id' => 44,
                'name' => 'skill',
                'guard_name' => 'api',
                'created_at' => '2022-12-04 22:35:33',
                'updated_at' => '2022-12-04 22:35:33',
            ),
            44 =>
            array (
                'id' => 45,
                'name' => 'distribute_subscription',
                'guard_name' => 'api',
                'created_at' => '2022-12-01 02:48:19',
                'updated_at' => '2022-12-01 02:48:19',
            ),
            45 =>
            array (
                'id' => 46,
                'name' => 'manage_version_update',
                'guard_name' => 'api',
                'created_at' => '2022-12-01 02:48:19',
                'updated_at' => '2022-12-01 02:48:19',
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
                'name' => 'page_management',
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
                'name' => 'forum_management',
                'guard_name' => 'api',
                'created_at' => '2022-12-01 02:48:19',
                'updated_at' => '2022-12-01 02:48:19',
            ),
        ));


    }
}
