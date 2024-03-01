<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('orders')->delete();

        \DB::table('orders')->insert(array (
            0 =>
            array (
                'id' => '1',
                'uuid' => '48d59c85-0c22-46bf-aa1b-d35dfab7740e',
                'order_no' => 'MO-23786441',
                'user_id' => '3',
                'placed_by_id' => NULL,
                'amount' => '313700.00',
                'fee' => '13700.00',
                'admin_approve' => 'Yes',
                'payment_type' => 'offline',
                'payment_status' => 'Pending',
                'loadable_id' => '1',
                'loadable_type' => 'App\\Models\\LoadPackage',
                'created_at' => '2024-02-17 09:22:56',
                'updated_at' => '2024-02-17 10:35:54',
            ),
            1 =>
            array (
                'id' => '2',
                'uuid' => '9758da2e-86c9-41f8-bf65-819e21c20d53',
                'order_no' => 'MO-86309211',
                'user_id' => '3',
                'placed_by_id' => NULL,
                'amount' => '7600.00',
                'fee' => '7600.00',
                'admin_approve' => 'Yes',
                'payment_type' => 'wallet',
                'payment_status' => 'Paid',
                'loadable_id' => '1',
                'loadable_type' => 'App\\Models\\LoadPackage',
                'created_at' => '2024-02-17 10:40:27',
                'updated_at' => '2024-02-17 11:12:51',
            ),
            2 =>
            array (
                'id' => '3',
                'uuid' => 'a17aa9c6-700b-434f-9e61-fd06c2f229f3',
                'order_no' => 'MO-45504007',
                'user_id' => '3',
                'placed_by_id' => NULL,
                'amount' => '7300.00',
                'fee' => '7300.00',
                'admin_approve' => 'Yes',
                'payment_type' => 'offline',
                'payment_status' => 'Pending',
                'loadable_id' => '1',
                'loadable_type' => 'App\\Models\\LoadPackage',
                'created_at' => '2024-02-17 11:18:55',
                'updated_at' => '2024-02-17 11:19:08',
            ),
            3 =>
            array (
                'id' => '4',
                'uuid' => '7c65b232-62a0-48b1-8b58-1da23c50cb6c',
                'order_no' => 'MO-72743822',
                'user_id' => '3',
                'placed_by_id' => NULL,
                'amount' => '8600.00',
                'fee' => '8600.00',
                'admin_approve' => 'Yes',
                'payment_type' => 'wallet',
                'payment_status' => 'Paid',
                'loadable_id' => '4',
                'loadable_type' => 'App\\Models\\Bulk',
                'created_at' => '2024-02-17 11:27:46',
                'updated_at' => '2024-02-17 11:28:05',
            ),

            4 =>
            array (
                'id' => '5',
                'uuid' => '7c65b232-62a0-48b1-8b58-1da23c90cb6c',
                'order_no' => 'MO-45504237',
                'user_id' => '3',
                'placed_by_id' => NULL,
                'amount' => '8600.00',
                'fee' => '8600.00',
                'admin_approve' => 'Yes',
                'payment_type' => 'wallet',
                'payment_status' => 'Paid',
                'loadable_id' => '2',
                'loadable_type' => 'App\\Models\\Bulk',
                'created_at' => '2024-02-17 11:27:46',
                'updated_at' => '2024-02-17 11:28:05',
            ),
            5 =>
            array (
                'id' => '6',
                'uuid' => '7c65b232-62a0-48b1-8b58-1da23c50co6c',
                'order_no' => 'MO-45504200',
                'user_id' => '3',
                'placed_by_id' => NULL,
                'amount' => '8600.00',
                'fee' => '8600.00',
                'admin_approve' => 'Yes',
                'payment_type' => 'wallet',
                'payment_status' => 'Paid',
                'loadable_id' => '2',
                'loadable_type' => 'App\\Models\\Bulk',
                'created_at' => '2024-02-17 11:27:46',
                'updated_at' => '2024-02-17 11:28:05',
            ),
        ));


    }
}
