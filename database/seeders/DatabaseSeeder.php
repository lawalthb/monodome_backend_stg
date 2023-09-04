<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(RolesTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);


        //$this->call(CountriesTableSeeder::class);
        //$this->call(StatesTableSeeder::class);
       // $this->call(CitiesTableSeeder::class);

        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(CityOneSeeder::class);
       // $this->call(CityTwoSeeder::class);
       // $this->call(CityThreeSeeder::class);
       // $this->call(CityFourSeeder::class);
      //  $this->call(CityFiveSeeder::class);


        $this->call(LoadTypesTableSeeder::class);
        $this->call(VehicleTypesTableSeeder::class);
        $this->call(VehicleMakesTableSeeder::class);
        $this->call(VehicleModelsTableSeeder::class);
    }
}
