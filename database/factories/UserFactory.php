<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
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
            'email_verified_at' => now(),
            // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'password' => Hash::make('password'),
            'provider_id' => NULL,
            'provider' => NULL,
            'address' => fake()->streetAddress(),
            'user_created_by' => NULL,
            'role_id' => '5',
            'imageUrl' => NULL,
            'user_type' => 'shipping_company',
            'role' => 'super_admin',
            'location' => NULL,
            'user_agent' => NULL,
            'status' => 'Pending',
            'remember_token' => Str::random(10),
            'deleted_at' => NULL,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
