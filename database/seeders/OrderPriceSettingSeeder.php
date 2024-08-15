<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderPriceSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        \DB::table('order_price_settings')->insert([
            [
                'name' => 'Monodome Admin Commission',
                'slug' => 'admin',
                'price' => 10,
                'is_default' => true,
                'status' => 'active'
            ],
            [
                'name' => 'Driver Commission',
                'slug' => 'driver',
                'price' => 70,
                'is_default' => true,
                'status' => 'active'
            ],
            [
                'name' => 'Agent Fee',
                'slug' => 'agent',
                'price' => 15,
                'is_default' => true,
                'status' => 'active'
            ],
            [
                'name' => 'Driver Manager Fee',
                'slug' => 'driver_manager',
                'price' => 20,
                'is_default' => true,
                'status' => 'active'
            ],
            [
                'name' => 'Truck Maintenance',
                'slug' => 'truck',
                'price' => 60,
                'is_default' => true,
                'status' => 'active'
            ]
        ]);
    }

}
