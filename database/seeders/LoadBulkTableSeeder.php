<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoadBulkTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('load_bulk')->delete();
        
        
        
    }
}