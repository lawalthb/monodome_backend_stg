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
            'expired' => now()->addYear(), // Assuming the plan expires in 1 year
            'status' => 'active',
        ]);

        Plan::create([
            'name' => 'Prime',
            'price' => 5000,
            'expired' => now()->addYear(), // Assuming the plan expires in 1 year
            'status' => 'active',
        ]);
    }
}
