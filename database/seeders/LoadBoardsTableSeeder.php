<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoadBoardsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('load_boards')->delete();
        
        \DB::table('load_boards')->insert(array (
            0 => 
            array (
                'id' => '1',
                'uuid' => '683db90f-0782-4ee9-9595-c824663ccbe6',
                'user_id' => '3',
                'acceptable_id' => NULL,
                'acceptable_type' => NULL,
                'load_type_id' => '1',
                'load_type_name' => 'package',
                'status' => 'pending',
                'status_comment' => NULL,
                'order_no' => 'MO-23786441',
                'load_date' => '2024-02-17 11:35:54',
                'loadable_id' => '1',
                'loadable_type' => 'App\\Models\\LoadPackage',
                'created_at' => '2024-02-17 10:35:54',
                'updated_at' => '2024-02-17 10:35:54',
            ),
            1 => 
            array (
                'id' => '2',
                'uuid' => '683db90f-0782-4ee9-9595-c824663ccbe6',
                'user_id' => '3',
                'acceptable_id' => NULL,
                'acceptable_type' => NULL,
                'load_type_id' => '1',
                'load_type_name' => 'package',
                'status' => 'pending',
                'status_comment' => NULL,
                'order_no' => 'MO-86309211',
                'load_date' => '2024-02-17 11:40:49',
                'loadable_id' => '2',
                'loadable_type' => 'App\\Models\\LoadPackage',
                'created_at' => '2024-02-17 10:40:49',
                'updated_at' => '2024-02-17 10:40:49',
            ),
            2 => 
            array (
                'id' => '3',
                'uuid' => '683db90f-0782-4ee9-9595-c824663ccbe6',
                'user_id' => '3',
                'acceptable_id' => NULL,
                'acceptable_type' => NULL,
                'load_type_id' => '1',
                'load_type_name' => 'package',
                'status' => 'pending',
                'status_comment' => NULL,
                'order_no' => 'MO-86309211',
                'load_date' => '2024-02-17 11:40:49',
                'loadable_id' => '2',
                'loadable_type' => 'App\\Models\\LoadPackage',
                'created_at' => '2024-02-17 10:40:49',
                'updated_at' => '2024-02-17 10:40:49',
            ),
            3 => 
            array (
                'id' => '4',
                'uuid' => '683db90f-0782-4ee9-9595-c824663ccbe6',
                'user_id' => '3',
                'acceptable_id' => NULL,
                'acceptable_type' => NULL,
                'load_type_id' => '1',
                'load_type_name' => 'package',
                'status' => 'pending',
                'status_comment' => NULL,
                'order_no' => 'MO-72743822',
                'load_date' => '2024-02-17 12:19:08',
                'loadable_id' => '3',
                'loadable_type' => 'App\\Models\\LoadPackage',
                'created_at' => '2024-02-17 11:19:08',
                'updated_at' => '2024-02-17 11:19:08',
            ),
            4 => 
            array (
                'id' => '5',
                'uuid' => '683db90f-0782-4ee9-9595-c824663ccbe6',
                'user_id' => '3',
                'acceptable_id' => NULL,
                'acceptable_type' => NULL,
                'load_type_id' => '1',
                'load_type_name' => 'package',
                'status' => 'pending',
                'status_comment' => NULL,
                'order_no' => 'MO-45504237',
                'load_date' => '2024-02-17 12:28:05',
                'loadable_id' => '4',
                'loadable_type' => 'App\\Models\\LoadPackage',
                'created_at' => '2024-02-17 11:28:05',
                'updated_at' => '2024-02-17 11:28:05',
            ),
            5 => 
            array (
                'id' => '6',
                'uuid' => '683db90f-0782-4ee9-9595-c824663ccbe6',
                'user_id' => '3',
                'acceptable_id' => NULL,
                'acceptable_type' => NULL,
                'load_type_id' => '1',
                'load_type_name' => 'package',
                'status' => 'pending',
                'status_comment' => NULL,
                'order_no' => 'MO-45504237',
                'load_date' => '2024-02-17 12:28:05',
                'loadable_id' => '4',
                'loadable_type' => 'App\\Models\\LoadPackage',
                'created_at' => '2024-02-17 11:28:05',
                'updated_at' => '2024-02-17 11:28:05',
            ),
        ));
        
        
    }
}