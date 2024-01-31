<?php

namespace Database\Factories;

use App\Models\Tracking;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tracking>
 */
class TrackingFactory extends Factory
{

    protected $model = Tracking::class;


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tracking_id' => $this->faker->unique()->uuid,
            'order_no' => $this->faker->unique()->randomNumber(5),
            'comment' => $this->faker->text,
            'time' => $this->faker->dateTime(),
            'longitude' => $this->faker->longitude,
            'latitude' => $this->faker->latitude,
            'location' => $this->faker->address,
            'driver_id' => function () {
                return \App\Models\Driver::factory()->create()->id;
            },
            'status' => $this->faker->randomElement(['Pending', 'In Progress', 'Completed']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
