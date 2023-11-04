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
        'country_id' => rand(1, 30),
        'state_id' => rand(1, 20),
        'street' => fake()->streetAddress(),
        'nin_number' => fake()->creditCardNumber(),
        'lga' => rand(1, 15),
        'business_name' => fake()->company(),
        'phone_number' => fake()->e164PhoneNumber(),
        'state_of_residence' => NULL,
        'city_of_residence' => NULL,
        'store_front_image' => 'uploads/agent/agent_images/1698664133vL1g5t1Kfs.png',
        'inside_store_image' => 'uploads/agent/agent_images/1698664133o7Je1um3DM.png',
        'registration_documents' => 'uploads/agent/agent_documents/16986641337GPKuGmdGb.pdf',
        'status' => 'Pending',
        'deleted_at' => NULL,
        ];


        // return [
        //     'uuid' => fake()->uuid(),
        //     'agent_code' => getOTPNumber(8),
        //     'user_id' => 20,
        //     'country_id' => rand(1, 150),
        //     'state_id' => rand(1, 150),
        //     'street' => fake()->streetAddress(),
        //     'nin_number' => fake()->creditCardNumber(),
        //     'lga' => rand(1, 150),
        //     'business_name' => fake()->company(),
        //     'phone_number' => fake()->e164PhoneNumber(),
        //     'state_of_residence' => NULL,
        //     'city_of_residence' => fake()->image($dir = $this->makePath('faker'), $width = 640, $height = 480),
        //     'store_front_image' => fake()->image($dir = $this->makePath('faker'), $width = 640, $height = 480),
        //     'inside_store_image' =>fake()->image($dir = $this->makePath('faker'), $width = 640, $height = 480),
        //     'registration_documents' => UploadedFile::fake()->create('test.pdf')->store('public/faker'),
        //     // 'registration_documents' => 'uploads/agent/agent_documents/1698672987e6eulgIV8a.pdf',
        //     'status' => 'Pending',
        //     'deleted_at' => NULL,
        //     ];


    }
}
