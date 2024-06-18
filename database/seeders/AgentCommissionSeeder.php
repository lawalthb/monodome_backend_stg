<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\AgentCommission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgentCommissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i=0; $i < 11; $i++) {

            AgentCommission::create([
                'state_id' => State::inRandomOrder()->id,
                'percentage' => rand(1, 100) / 100,
            ]);

        }
    }
}
