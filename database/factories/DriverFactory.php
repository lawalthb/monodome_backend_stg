<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Driver>
 */
class DriverFactory extends Factory
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
            'user_id' => 4,
            'state_id' => rand(1, 30),
            'type' => fake()->randomElement(['driver', 'drives']),
            'have_motor' => fake()->randomElement(['Yes', 'No']),
            'street' => fake()->streetAddress(),
            'lga' => rand(1, 20),
            'nin_number' => fake()->creditCardNumber(),
            'license_number' => fake()->creditCardNumber(),
            'proof_of_license' => 'uploads/driver/driver_images/1694709150yxRajE7Bte.png',
            'vehicle_type_id' => rand(1, 5),
            'profile_picture' => 'uploads/driver/driver_images/1694709460bsHD1NUuNb.png',
            'status' => 'Pending',
            'deleted_at' => NULL,
        ];
    }
}
