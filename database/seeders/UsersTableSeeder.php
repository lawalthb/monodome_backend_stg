<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Agent;
use App\Models\Truck;
use App\Models\Broker;
use App\Models\Driver;
use App\Models\Wallet;
use App\Models\Company;
use App\Models\Guarantor;
//use Doctrine\DBAL\DriverManager;
use App\Models\DriverManger;
use App\Models\ShippingCompany;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Database\Factories\DriverManagerFactory;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */

     public function run()
     {

        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'full_name' => 'super admin',
                'email' => 'admin@monodome.co',
                'phone_number' => "+234778837737",
                'email_verified_at' => now(),
                'password' => '$2y$10$8LBMPVdIM97Sxh2q2diibeo/zvg40EWUe929AtVjuHZSi.NWvO1om',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'ref_by' => NULL,
                'referral_code' => generateReferralCode(),
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'super_admin',
                'role' => NULL,
                'location' => NULL,
                'user_agent' => NULL,
                'isPremium' => 1,
                'status' => 'Confirmed',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:22:23',
                'updated_at' => '2023-10-30 13:22:23',
            ),
            1 =>
            array (
                'id' => 2,
                'full_name' => 'admin',
                'email' => 'admin@example.com',
                'phone_number' => "+334739393833",
                'email_verified_at' => now(),
                'password' => '$2y$10$rmBJp3285EEP9N9gDVorN.oKJF/0gEEm25pCkrzRBWs3auEFT2Hk6',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'ref_by' => 1,
                'referral_code' => generateReferralCode(),
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'admin',
                'role' => NULL,
                'location' => NULL,
                'user_agent' => NULL,
                'isPremium' => 1,
                'status' => 'Confirmed',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:22:23',
                'updated_at' => '2023-10-30 13:22:23',
            ),
            2 =>
            array (
                'id' => 3,
                'full_name' => 'Customer',
                'email' => 'customer@gmail.com',
                'phone_number' => "+234883933",
                'email_verified_at' => now(),
                'password' => '$2y$10$ls19QB7MfG39OL0BmrkLVuzgN1VbAyQ/UlkzIfGbWBCyu/5cFIfTG',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'ref_by' => 1,
                'referral_code' => generateReferralCode(),
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'customer',
                'role' => NULL,
                'location' => NULL,
                'user_agent' => NULL,
                'isPremium' => 1,
                'status' => 'Confirmed',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:22:23',
                'updated_at' => '2023-10-30 13:22:23',
            ),
            3 =>
            array (
                'id' => 4,
                'full_name' => 'driver driver',
                'email' => 'driver@gmail.com',
                'phone_number' => "+23467839939",
                'email_verified_at' => now(),
                'password' => '$2y$10$ls19QB7MfG39OL0BmrkLVuzgN1VbAyQ/UlkzIfGbWBCyu/5cFIfTG',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'ref_by' => 1,
                'referral_code' => generateReferralCode(),
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'driver',
                'role' => NULL,
                'location' => NULL,
                'user_agent' => NULL,
                'isPremium' => 1,
                'status' => 'Confirmed',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:22:23',
                'updated_at' => '2023-10-30 13:22:23',
            ),

            4 =>
            array (
                'id' => 5,
                'full_name' => 'driver manager',
                'email' => 'drivermanager@gmail.com',
                'phone_number' => "+234708474747",
                'email_verified_at' => now(),
                'password' => '$2y$10$ls19QB7MfG39OL0BmrkLVuzgN1VbAyQ/UlkzIfGbWBCyu/5cFIfTG',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'ref_by' => 1,
                'referral_code' => generateReferralCode(),
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'driver_manager',
                'role' => 'super_admin',
                'location' => NULL,
                'user_agent' => NULL,
                'isPremium' => 1,
                'status' => 'Confirmed',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:22:23',
                'updated_at' => '2023-10-30 13:22:23',
            ),



            5 =>
            array (
                'id' => 6,
                'full_name' => 'company transporter',
                'email' => 'companytransporter@gmail.com',
                'phone_number' => "+234708474427",
                'email_verified_at' => now(),
                'password' => '$2y$10$ls19QB7MfG39OL0BmrkLVuzgN1VbAyQ/UlkzIfGbWBCyu/5cFIfTG',
                'provider_id' => NULL,
                'provider' => NULL,
                'address' => NULL,
                'user_created_by' => NULL,
                'ref_by' => 1,
                'referral_code' => generateReferralCode(),
                'role_id' => NULL,
                'imageUrl' => NULL,
                'user_type' => 'company_transport',
                'role' => 'super_admin',
                'location' => NULL,
                'user_agent' => NULL,
                'isPremium' => 1,
                'status' => 'Confirmed',
                'remember_token' => NULL,
                'deleted_at' => NULL,
                'created_at' => '2023-10-30 13:22:23',
                'updated_at' => '2023-10-30 13:22:23',
            ),

        ));

        // adding money to customer
        $wallet = new Wallet;
        $wallet->amount = 100000;
        $wallet->status = 'active';
        $wallet->user_id = 3;
        $wallet->save();


        //driver
       Driver::factory()->create([
            'user_id' => 4,
        ]);

         //driver manager
         DriverManger::factory()->create([
          'user_id' => 5,
         ]);

        User::find(1)->assignRole('Super Admin');
        User::find(2)->assignRole('admin');
        User::find(3)->assignRole('Customer');
        User::find(4)->assignRole('Driver');
        User::find(5)->assignRole('Driver Manager');
        User::find(6)->assignRole('Company Transport');


        $statuses = ['Pending', 'Confirmed'];


        //customer
        $customerRole = Role::find(3);
        for ($i = 1; $i <= 50; $i++) {

        $randomStatus = $statuses[array_rand($statuses)];

        // Create a user
        $user = \App\Models\User::factory()->create([
            'user_type' => "Customer",
            'role_id' => 3,
            'ref_by' => rand(1,4),
            'status' => $randomStatus,
            'referral_code' => generateReferralCode(),
        ]);

        // Assign the "agent" role to the user
        $user->assignRole($customerRole);

          }


        //broker
        $brokerRole = Role::find(4);
        for ($i = 1; $i <= 50; $i++) {

            $randomStatus = $statuses[array_rand($statuses)];

        // Create a user
        $user = \App\Models\User::factory()->create([
            'user_type' => "broker",
            'role_id' => 4,
            'ref_by' => rand(1,3),
            'status' => $randomStatus,
            'referral_code' => generateReferralCode(),
        ]);

        $broker = Broker::factory()->create([
            'user_id' => $user->id,
          //  'status' => $user->status,
        ]);

        // Assign the "broker" role to the user
        $user->assignRole($brokerRole);

        }

        $agentRole = Role::find(6);

        for ($i = 1; $i <= 50; $i++) {
            // Create a user
            $randomStatus = $statuses[array_rand($statuses)];

            $user = \App\Models\User::factory()->create([
                'user_type' => "agent",
                'role_id' => 6,
                'ref_by' => rand(1,4),
                'status' => $randomStatus,
                'referral_code' => generateReferralCode(),
            ]);

            // Assign the "agent" role to the user
            $user->assignRole($agentRole);

            // Create an agent and associate it with the user
            $agent = Agent::factory()->create([
                'user_id' => $user->id,
                'status' => $user->status,
            ]);

            $guarantor1 = Guarantor::factory()->create([
                'loadable_id' => $agent->id,
                'loadable_type' => 'App\\Models\\Agent',
            ]);

            $guarantor2 = Guarantor::factory()->create([
                'loadable_id' => $agent->id,
                'loadable_type' => 'App\\Models\\Agent',
            ]);
        }



        //Clearing and Forwarding Agent
        $clearingRole = Role::find(7);

        for ($i = 1; $i <= 50; $i++) {
            $randomStatus = $statuses[array_rand($statuses)];

            // Create a user
            $user = \App\Models\User::factory()->create([
                'user_type' => "clearing",
                'role_id' => 7,
                'ref_by' => rand(1,4),
                'status' => $randomStatus,
                'referral_code' => generateReferralCode(),
            ]);

            // Assign the "agent" role to the user
            $user->assignRole($clearingRole);

            // Create an agent and associate it with the user
            $agent = Agent::factory()->create([
                'user_id' => $user->id,
                'status' => $user->status,
                'type' => "clearing",
                'cac_certificate' => "uploads/agent/agent_images/1698664133vL1g5t1Kfs.png",
                'other_documents' => "uploads/agent/agent_images/1698664133vL1g5t1Kfs.png",
            ]);

            $guarantor1 = Guarantor::factory()->create([
                'loadable_id' => $agent->id,
                'loadable_type' => 'App\\Models\\Agent',
            ]);

            $guarantor2 = Guarantor::factory()->create([
                'loadable_id' => $agent->id,
                'loadable_type' => 'App\\Models\\Agent',
            ]);
        }


         //driver
         $driverRole = Role::find(8);

         for ($i = 1; $i <= 50; $i++) {
            // Create a user
            $user = \App\Models\User::factory()->create([

                'user_type' => "driver",
                'role' => "driver",
                'role_id' => 8,
                'ref_by' => rand(1,5),
                'referral_code' => generateReferralCode(),
            ]);


            // Create an agent and associate it with the user
            $agent = Driver::factory()->create([
                'user_id' => $user->id,
            ]);

            $user->assignRole($driverRole);

            $guarantor1 = Guarantor::factory()->create([
               'loadable_id' => $agent->id,
               'loadable_type' => 'App\\Models\\Driver',
           ]);

           $guarantor2 = Guarantor::factory()->create([
               'loadable_id' => $agent->id,
               'loadable_type' => 'App\\Models\\Driver',
           ]);

        }

        // for Shipping Company
        $ShippingCompanyRole = Role::find(5);

         for ($i = 1; $i <= 50; $i++) {

            $randomStatus = $statuses[array_rand($statuses)];

            // Create a user
            $user = \App\Models\User::factory()->create([

                'user_type' => "shipping_company",
                'role' => "shipping_company",
                'role_id' => 5,
                'ref_by' => rand(1,5),
                'status' => $randomStatus,
                'referral_code' => generateReferralCode(),
            ]);


            // Create an shipping company and associate it with the user
            $agent = ShippingCompany::factory()->create([
                'user_id' => $user->id,
            ]);

            $user->assignRole($ShippingCompanyRole);

            $guarantor1 = Guarantor::factory()->create([
               'loadable_id' => $agent->id,
               'loadable_type' => 'App\\Models\\ShippingCompany',
           ]);
        }

       // driver manager
        $driverManager = Role::find(9);

        for ($i = 1; $i <= 50; $i++) {

            $randomStatus = $statuses[array_rand($statuses)];

           // Create a user
           $user = \App\Models\User::factory()->create([

               'user_type' => "driver_manager",
              // 'role' => "driver_manager",
               'role_id' => 9,
               'ref_by' => rand(1,5),
               'status' => $randomStatus,
               'referral_code' => generateReferralCode(),
           ]);


           // Create an driver manager and associate it with the user
           $agent = DriverManger::factory()->create([
               'user_id' => $user->id,
              // 'status' => $user->status,
           ]);

           $user->assignRole($driverManager);

           $guarantor1 = Guarantor::factory()->create([
              'loadable_id' => $agent->id,
              'loadable_type' => 'App\\Models\\DriverManger',
          ]);
       }

         // Company Transport
         $company = Role::find(10);

         for ($i = 1; $i <= 50; $i++) {

             $randomStatus = $statuses[array_rand($statuses)];

            // Create a user
            $user = \App\Models\User::factory()->create([

                'user_type' => "company",
               // 'role' => "driver_manager",
                'role_id' => 10,
                'ref_by' => rand(1,5),
                'status' => $randomStatus,
                'referral_code' => generateReferralCode(),
            ]);


            // Create an Company Transport and associate it with the user
            $agent = Company::factory()->create([
                'user_id' => $user->id,
               // 'status' => $user->status,
            ]);

            $user->assignRole($company);

            $guarantor1 = Guarantor::factory()->create([
               'loadable_id' => $agent->id,
               'loadable_type' => 'App\\Models\\Company',
           ]);
        }




        // Truck

        $role = Role::find(11);

        for ($i = 1; $i <= 50; $i++) {

            $randomStatus = $statuses[array_rand($statuses)];

           // Create a user
           $user = \App\Models\User::factory()->create([

               'user_type' => "Truck",
              // 'role' => "driver_manager",
               'role_id' => 11,
               'ref_by' => rand(1,5),
               'status' => $randomStatus,
               'referral_code' => generateReferralCode(),
           ]);


           // Create an truck  and associate it with the user
           $agent = Truck::factory()->create([
               'user_id' => $user->id,
              // 'status' => $user->status,
           ]);

           $user->assignRole($role);

           $guarantor1 = Guarantor::factory()->create([
              'loadable_id' => $agent->id,
              'loadable_type' => 'App\\Models\\Truck',
          ]);
       }



        \DB::table('employees')->delete();

        for ($i = 1; $i <= 50; $i++) {

            $randomStatus = $statuses[array_rand($statuses)];

        \DB::table('employees')->insert(array (
            0 =>
            array (
                'uuid' => fake()->uuid(),
                'full_name' => fake()->name(),
                'address' =>  fake()->streetAddress(),
                'phone_number' => fake()->e164PhoneNumber(),
                'email' => fake()->unique()->safeEmail(),
                'department' => fake()->company(),
           //     'status' => $randomStatus,
            ),
        ));
    }

    }

}
