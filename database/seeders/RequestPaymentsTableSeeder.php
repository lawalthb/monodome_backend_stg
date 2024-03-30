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
        ));
        
        
    }
}