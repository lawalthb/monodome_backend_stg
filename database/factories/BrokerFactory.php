<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class BrokerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'id' => 2,
            'uuid' => '00028732-7976-4b75-9f9f-adc2dd15c5f0',
            'user_id' => 10,
            'state_id' => 23,
            'street' => 'Orville Mission',
            'lga' => '2',
            'phone_number' => NULL,
            'nin_number' => '322223425',
            'profile_picture' => 'uploads/broker/broker_images/1698664133o7Je1um3DM.png',
            'status' => 'Waiting',
            'created_at' => '2023-10-30 13:28:16',
            'updated_at' => '2023-10-30 13:28:16',
            'deleted_at' => NULL,
        ];


    }
}
