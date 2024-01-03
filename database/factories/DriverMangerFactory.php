<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DriverManger>
 */
class DriverMangerFactory extends Factory
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
            'country_id' => rand(1, 30),
            'business_name' => fake()->company(),
           // 'have_motor' => fake()->randomElement(['Yes', 'No']),
            'street' => fake()->streetAddress(),
            'lga' => rand(1, 20),
            // 'nin_number' => fake()->creditCardNumber(),
            'phone_number' => fake()->creditCardNumber(),
            'cac_certificate' => 'uploads/driver/driver_images/1694709150yxRajE7Bte.png',
            'office_front_image' => 'uploads/driver/driver_images/1694709150yxRajE7Bte.png',
            'inside_office_image' => 'uploads/driver/driver_images/1694709150yxRajE7Bte.png',
            'registration_documents' => 'uploads/driver/driver_images/1694709460bsHD1NUuNb.png',
            'status' => 'Pending',
            'deleted_at' => NULL,
        ];
    }
}
