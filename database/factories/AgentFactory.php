<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agent>
 */
class AgentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'uuid' => fake()->uuid(),
        'agent_code' => getOTPNumber(8),
        'user_id' => 20,
        'country_id' => rand(1, 150),
        'state_id' => rand(1, 150),
        'street' => fake()->streetAddress(),
        'nin_number' => fake()->creditCardNumber(),
        'lga' => rand(1, 150),
        'business_name' => fake()->company(),
        'phone_number' => fake()->e164PhoneNumber(),
        'state_of_residence' => NULL,
        'city_of_residence' => NULL,
        'store_front_image' => 'uploads/agent/agent_images/1698672987H6I61xihIp.png',
        'inside_store_image' => 'uploads/agent/agent_images/1698672987x1VhK714G9.png',
        'registration_documents' => 'uploads/agent/agent_documents/1698672987e6eulgIV8a.pdf',
        'status' => 'Pending',
        'deleted_at' => NULL,
        ];
    }
}
