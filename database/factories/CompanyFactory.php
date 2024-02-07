<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingCompany>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        //    'id' => 4,
            'uuid' => '0f2a8ea8-d267-4923-949c-0a6514088c43',
            'user_id' => 19,
            'state_id' => rand(1, 30),
            'street' => fake()->streetAddress(),
            'lga' => rand(1, 30),
            'state_of_residence' => '22',
            'city_of_residence' => '44',
            'number_of_drivers' => rand(6, 300),
            'number_of_trucks' => rand(100, 3000),
            'truck_type' =>rand(1, 3),
            'phone_number' => NULL,
            'company_logo' => 'uploads/company/company_images/1698672864XN29Pev1B0.png',
            'company_name' => fake()->streetAddress(),
            'cac_documents' => 'uploads/company/company_documents/1698672864oY8xxvqKC5.pdf',
        //    'status' => 'Pending',
            'created_at' => '2023-10-30 13:34:24',
            'updated_at' => '2023-10-30 13:34:24',
            'deleted_at' => NULL,
        ];
    }
}
