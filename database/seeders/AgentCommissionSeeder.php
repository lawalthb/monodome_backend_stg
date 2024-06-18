<?php

namespace Database\Seeders;

use App\Models\State;
use App\Models\LocalState;
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
        for ($i = 0; $i < 10; $i++) {
            $state = LocalState::inRandomOrder()->first();

            if ($state) {
                AgentCommission::create([
                    'state_id' => $state->id,
                    'percentage' => rand(1, 100) / 100,
                ]);
            }
        }
    }
}
