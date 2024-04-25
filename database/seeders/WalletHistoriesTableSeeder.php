<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WalletHistoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('wallet_histories')->delete();

        \DB::table('wallet_histories')->insert(array (
            0 =>
            array (
                'id' => 5,
                'user_id' => 3,
                'wallet_id' => 1,
                'type' => 'credit',
                'payment_type' => 'wallet',
                'paystack_reference' => NULL,
                'amount' => '26000.000000000000000000',
                'closing_balance' => '26000.000000000000000000',
                'fee' => 0.0,
                'description' => 'Received payment with the following ID: 98626629-3a3c-4e24-91ab-ea062f31be3f',
                'created_at' => '2024-03-30 10:36:47',
                'updated_at' => '2024-03-30 10:36:47',
            ),
            1 =>
            array (
                'id' => 6,
                'user_id' => 3,
                'wallet_id' => 1,
                'type' => 'debit',
                'payment_type' => 'wallet',
                'paystack_reference' => NULL,
                'amount' => '26000.000000000000000000',
                'closing_balance' => '74000.000000000000000000',
                'fee' => 0.0,
                'description' => 'Sent payment with the following ID: 98626629-3a3c-4e24-91ab-ea062f31be3f',
                'created_at' => '2024-03-30 10:36:47',
                'updated_at' => '2024-03-30 10:36:47',
            ),
        ));


    }
}
