<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class WalletsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('wallets')->delete();
        
        \DB::table('wallets')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => '3158 3700 587 2176',
                'wallet_type' => 'monolog_wallet',
                'user_id' => 3,
                'amount' => '74000.00',
                'pin' => NULL,
                'status' => 'active',
                'created_at' => '2024-03-30 10:24:20',
                'updated_at' => '2024-03-30 10:36:47',
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => '9518 2015 369 2780',
                'wallet_type' => 'monolog_wallet',
                'user_id' => 4,
                'amount' => '26000.00',
                'pin' => NULL,
                'status' => 'active',
                'created_at' => '2024-03-30 10:28:12',
                'updated_at' => '2024-03-30 10:36:47',
            ),
        ));
        
        
    }
}