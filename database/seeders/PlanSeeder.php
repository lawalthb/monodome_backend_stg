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
            'expired' => rand(1,12),
            'status' => 'active',
        ]);

        Plan::create([
            'name' => 'Prime',
            'price' => 5000,
            'expired' => rand(1,12),
            'status' => 'active',
        ]);
    }
}
