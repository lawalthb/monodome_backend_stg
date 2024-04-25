<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class RequestPaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('request_payments')->delete();
        
        \DB::table('request_payments')->insert(array (
            0 => 
            array (
                'id' => 1,
                'request_sender' => 4,
                'request_receiver' => 3,
                'currency_id' => NULL,
                'uuid' => '98626629-3a3c-4e24-91ab-ea062f31be3f',
                'amount' => '30000.00000000',
                'accept_amount' => '26000.00000000',
                'email' => NULL,
                'phone' => NULL,
                'purpose' => NULL,
                'comment' => 'just check it how is it',
                'status' => 'Success',
                'created_at' => '2024-03-30 10:29:52',
                'updated_at' => '2024-03-30 10:36:47',
            ),
            1 => 
            array (
                'id' => 2,
                'request_sender' => 3,
                'request_receiver' => 6,
                'currency_id' => NULL,
                'uuid' => '51711432-2157-4c66-979b-6c004380208e',
                'amount' => '30000.00000000',
                'accept_amount' => '0.00000000',
                'email' => NULL,
                'phone' => NULL,
                'purpose' => NULL,
                'comment' => 'Nigeria is hard o, i wan use am chop',
                'status' => 'Pending',
                'created_at' => '2024-04-25 18:30:35',
                'updated_at' => '2024-04-25 18:30:35',
            ),
            2 => 
            array (
                'id' => 3,
                'request_sender' => 6,
                'request_receiver' => 3,
                'currency_id' => NULL,
                'uuid' => 'b056eab6-4a9c-406d-b112-0dba0735d2b9',
                'amount' => '50000.00000000',
                'accept_amount' => '0.00000000',
                'email' => NULL,
                'phone' => NULL,
                'purpose' => NULL,
                'comment' => 'i wan use am chop',
                'status' => 'Pending',
                'created_at' => '2024-04-25 18:42:03',
                'updated_at' => '2024-04-25 18:42:03',
            ),
        ));
        
        
    }
}