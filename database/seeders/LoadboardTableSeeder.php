<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoadboardTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('loadboard')->delete();

        \DB::table('loadboard')->insert(array (
            0 =>
            array (
                'id' => 1,
                'user_id' => 5,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => "MO-23786441",
                'load_date' => '2023-08-21 00:00:00',
            ),
            1 =>
            array (
                'id' => 2,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => "MO-86309211",
                'load_date' => '2023-08-21 00:00:00',
            ),
            2 =>
            array (
                'id' => 3,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => "MO-45504007",
                'load_date' => '2023-08-21 00:00:00',
            ),
            3 =>
            array (
                'id' => 4,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => "MO-72743822",
                'load_date' => '2023-08-21 00:00:00',
            ),
            4 =>
            array (
                'id' => 5,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => "MO-45504237",
                'load_date' => '2023-08-21 00:00:00',
            ),
            5 =>
            array (
                'id' => 6,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => 8,
                'load_date' => '2023-08-21 00:00:00',
            ),
            6 =>
            array (
                'id' => 7,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => 1,
                'load_date' => '2023-08-21 00:00:00',
            ),
            7 =>
            array (
                'id' => 8,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => 273547,
                'load_date' => '2023-08-21 00:00:00',
            ),
            8 =>
            array (
                'id' => 9,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => 522642,
                'load_date' => '2023-08-22 00:00:00',
            ),
            9 =>
            array (
                'id' => 10,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => 192856,
                'load_date' => '2023-08-22 00:00:00',
            ),
            10 =>
            array (
                'id' => 11,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => 342688,
                'load_date' => '2022-08-30 00:00:00',
            ),
            11 =>
            array (
                'id' => 12,
                'user_id' => 7,
                'loadtype' => 1,
                'loadtype_name' => 'package',
                'status' => 'Pending',
                'order_no' => 581409,
                'load_date' => '2023-08-30 20:21:41',
            ),
        ));


    }
}
