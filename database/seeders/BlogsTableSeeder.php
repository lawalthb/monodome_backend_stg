<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class BlogsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {

      //  \DB::table('blogs')->delete();
       // \DB::table('categories')->delete();
        // $faker = Faker::create(); // Create an instance of Faker

        // $statuses = ['draft', 'confirmed', 'published', 'rejected'];


        // for ($i = 0; $i < 50; $i++) {
        //     \DB::table('categories')->insert([
        //         'name' => $faker->word(),
        //         'image' => 'uploads/blog/17047151138T6QD3nofY.png',
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]);
        // }


        // for ($i = 0; $i < 50; $i++) {

        //     $randomStatus = $statuses[array_rand($statuses)];

        //     \DB::table('blogs')->insert([
        //         'title' => $faker->sentence(),
        //         'body' => $faker->paragraph(),
        //         'image' => 'uploads/blog/17047151138T6QD3nofY.png',
        //         'user_id' => rand(1, 4),
        //         'category_id' => rand(1, 50),
        //         'status' => $randomStatus,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]);
        // }


        // for ($i = 0; $i < 50; $i++) {
        //     $randomStatus = $statuses[array_rand($statuses)];

        //     \DB::table('comments')->insert([
        //         'blog_id' =>rand(1, 49),
        //         'full_name' => $faker->name(),
        //         'email' => $faker->email(),
        //         'comment' => $faker->sentence(),
        //         'status' => $randomStatus,
        //         'created_at' => now(),
        //         'updated_at' => now()
        //     ]);
        // }




    //     for ($i = 0; $i < 50; $i++) {

    //     \DB::table('blogs')->insert(array (
    //             'title' => fake()->sentences(),
    //             'body' => fake()->paragraphs(),
    //             'image' => 'uploads/blog/1704623533OnXAgrptnA.jpg',
    //             'user_id' => rand(1, 4),
    //             'status' => rand(1, 0),
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //     ));

    // }

    }
}
