<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingCompany>
 */
class ShippingCompanyFactory extends Factory
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
                'user_id' => 11,
                'state_id' => rand(1, 30),
                'company_name' => fake()->company(),
                'street' => fake()->streetAddress(),
                'lga' => rand(1, 100),
                'phone_number' => fake()->e164PhoneNumber(),
                'nin_number' => fake()->creditCardNumber(),
                'profile_picture' => 'uploads/broker/broker_images/1694596427Cndhetfsv8.jpg',
                'status' => 'Waiting',
                'deleted_at' => NULL,
        ];
    }
}
