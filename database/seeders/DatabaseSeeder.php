<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use DistanceSettingSeeder;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;
use Database\Seeders\CityOneSeeder;
use Database\Seeders\SettingsSeeder;

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
        $this->call(RoleHasPermissionsTableSeeder::class);
        $this->call(ModelHasRolesTableSeeder::class);


        $this->call(CountrySeeder::class);
        $this->call(StateSeeder::class);
        $this->call(StatesTableSeeder::class);
        $this->call(LocalGovernmentsTableSeeder::class);


        $this->call(PriceSettingsSeeder::class);
        $this->call(DistanceSeeder::class);
        //  $this->call(StateSeeder::class);
         $this->call(CityOneSeeder::class);
        sleep(5);
        $this->call(CityTwoSeeder::class);
        sleep(5);
        $this->call(CityThreeSeeder::class);
        sleep(5);
        $this->call(CityFourSeeder::class);
        sleep(5);
        $this->call(CityFiveSeeder::class);


        $this->call(LoadTypesTableSeeder::class);
        $this->call(VehicleTypesTableSeeder::class);
        $this->call(VehicleMakesTableSeeder::class);
        $this->call(VehicleModelsTableSeeder::class);
        $this->call(SettingsSeeder::class);

        $this->call(AdminSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BlogsTableSeeder::class);
        $this->call(TrackingsTableSeeder::class);
        $this->call(ChatSeeder::class);



        $this->call(EmployeesTableSeeder::class);
       // $this->call(OrdersTableSeeder::class);
       // $this->call(LoadBoardsTableSeeder::class);
       // $this->call(LoadPackagesTableSeeder::class);
    }
}
