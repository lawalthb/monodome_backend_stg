<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        \DB::table('users')->delete();

       // Create Super Admin user
       $superAdmin = DB::table('users')->insertGetId([
        'full_name' => 'super admin',
        'user_type' => 'super_admin',
        'email' => 'admin@monodome.co',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Create Admin user
    $admin = DB::table('users')->insertGetId([
        'full_name' => 'admin',
        'user_type' => 'admin',
        'email' => 'admin@example.com',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);


      // Create Admin user
      $customer = DB::table('users')->insertGetId([
        'full_name' => 'Customer',
        'user_type' => 'User',
        'email' => 'customer@gmail.com',
        'password' => Hash::make('password'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    // Find the roles
    $superAdminRole = Role::where('name', 'Super Admin')->first();
    $adminRole = Role::where('name', 'Admin')->first();

    // Assign roles to users
    $superAdminRole = Role::where('name', 'Super Admin')->first();
    $adminRole = Role::where('name', 'Admin')->first();

    $CustomerRole = Role::where('name', 'Customer')->first();
   // $adminRole = Role::where('name', 'Customer')->first();

    // Assign roles to users if they don't already have them
    if ($superAdminRole && $adminRole) {
        if (!$superAdminRole->users->contains($superAdmin)) {
            $superAdminRole->users()->attach($superAdmin);
        }

        if (!$adminRole->users->contains($admin)) {
            $adminRole->users()->attach($admin);
        }

        if (!$CustomerRole->users->contains($customer)) {
            $CustomerRole->users()->attach($customer);
        }
    }

    // Assign roles to usersu
   //     $superAdminRole = Role::create(['name' => 'super admin']);
     //   $adminRole = Role::create(['name' => 'admin']);

        // Assign roles to users
        // DB::table('model_has_roles')->insert([
        //     'role_id' => 1,
        //     'model_type' => 'App\Models\User',
        //     'model_id' => $superAdmin,
        // ]);

        // DB::table('model_has_roles')->insert([
        //     'role_id' => 2,
        //     'model_type' => 'App\Models\User',
        //     'model_id' => $admin,
        // ]);
    }
}
