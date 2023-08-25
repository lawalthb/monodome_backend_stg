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
        'full_name' => 'superadmin',
        'user_type' => 'superadmin',
        'email' => 'superadmin@example.com',
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

    // Find the roles
    $superAdminRole = Role::where('name', 'Super Admin')->first();
    $adminRole = Role::where('name', 'Admin')->first();

    // Assign roles to users
    if ($superAdminRole && $adminRole) {
        DB::table('model_has_roles')->insert([
            'role_id' => $superAdminRole->id,
            'model_type' => 'App\Models\User',
            'model_id' => $superAdmin,
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => $adminRole->id,
            'model_type' => 'App\Models\User',
            'model_id' => $admin,
        ]);
    }


        // Assign roles to users
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
