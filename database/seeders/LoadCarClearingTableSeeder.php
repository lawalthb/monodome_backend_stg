<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoadCarClearingTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('load_car_clearing')->delete();
        
        
        
    }
}