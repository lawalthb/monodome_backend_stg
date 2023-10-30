<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Guarantor>
 */
class GuarantorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'full_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => fake()->e164PhoneNumber(),
            'street' => fake()->streetAddress(),
            'state' => rand(1, 30),
            'lga' => rand(1, 100),
            'profile_picture' => 'uploads/agent/guarantor_images/1698664133GZJKEIyCy3.jpg',
            'state_of_residence' => NULL,
            'city_of_residence' => NULL,
            'loadable_id' => 1,
            'loadable_type' => 'App\\Models\\Agent',
        ];
    }
}
