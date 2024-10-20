<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingCompany>
 */
class TruckFactory extends Factory
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
                'street' => fake()->streetAddress(),
                'lga' => rand(1, 50),
                'phone_number' => fake()->e164PhoneNumber(),
               // 'nin_number' => fake()->creditCardNumber(),
                'profile_picture' => 'uploads/broker/broker_images/1694596427Cndhetfsv8.jpg',
                'status' => 'Pending',
                'business_name' => fake()->company(),
                'country_id' => rand(1, 29),
                'truck_name' =>  fake()->jobTitle(),
                'truck_type' =>  fake()->jobTitle(),
                'truck_location' => fake()->streetAddress(),
                'truck_make' => fake()->company(),
                'plate_number' => fake()->creditCardNumber(),
                'cac_number' => fake()->creditCardNumber(),
                'truck_description' => fake()->text(),
                'outside_truck_picture' => 'uploads/broker/broker_images/1694596427Cndhetfsv8.jpg',
                'truck_document' => NULL,
        ];
    }
}
