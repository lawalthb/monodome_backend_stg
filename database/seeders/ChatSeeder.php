<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Faker\Factory as Faker;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Insert sample data into the 'chats' table
        for ($i = 1; $i <= 50; $i++) {
            DB::table('chats')->insert([
                'sender_id' => $faker->numberBetween(1, 10), // Assuming users table has 10 records
                'receiver_id' => $faker->numberBetween(1, 10),
                'message' => $faker->text,
                'file_path' => $faker->imageUrl(), // Replace with appropriate file path generation logic
                'loadable_id' => $faker->numberBetween(1, 20), // Assuming some loadable records exist
                'loadable_type' => 'App\Models\LoadableModel', // Replace with your actual loadable model class
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
