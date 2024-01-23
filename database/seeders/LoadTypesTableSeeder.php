<?php

namespace Database\Seeders;

use DB;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class LoadTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        DB::table('load_types')->delete();

        \DB::table('load_types')->insert(array (
            0 =>
            array (
                'id' => 1,
                'uuid' => Str::uuid()->toString(),
                'name' => 'package',
                'slug' => 'package',
                'is_active' => 'Yes',
            ),
            1 =>
            array (
                'id' => 2,
                'uuid' => Str::uuid()->toString(),
                'name' => 'bulk',
                'slug' => 'bulk',
                'is_active' => 'Yes',
            ),
            2 =>
            array (
                'id' => 3,
                'uuid' => Str::uuid()->toString(),
                'name' => 'car clearing',
                'slug' => 'car-clearing',
                'is_active' => 'Yes',
            ),
            3 =>
            array (
                'id' => 4,
                'uuid' => Str::uuid()->toString(),
                'name' => 'container shipment',
                'slug' => 'container-shipment',
                'is_active' => 'Yes',
            ),
            4 =>
            array (
                'id' => 5,
                'uuid' => Str::uuid()->toString(),
                'name' => 'specialize shipment',
                'slug' => 'specialize-shipment',
                'is_active' => 'Yes',
            ),

            5 =>
            array (
                'id' => 6,
                'uuid' => Str::uuid()->toString(),
                'name' => 'Document',
                'slug' => 'document',
                'is_active' => 'Yes',
            ),
        ));


    }
}
