<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'name' => 'Premium',
            'price' => 2000,
            'image' => 'uploads/vehicle_image/1698672302qDxhNFotJz.PNG',
            'expired' => rand(1,12),
            'status' => 'active',
        ]);

        Plan::create([
            'name' => 'Prime',
            'price' => 5000,
            'image' => 'uploads/vehicle_image/1698672302qDxhNFotJz.PNG',
            'expired' => rand(1,12),
            'status' => 'active',
        ]);
    }
}
