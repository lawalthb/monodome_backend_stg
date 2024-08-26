<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('admins')->insert([
        //     [
        //         'name' => 'Monodome Admin',
        //         'phone' => '8166925166',
        //         'username' => 'admin',
        //         'email' => 'admin@monodome.co',
        //         'password' => Hash::make('12345678'),
        //         'status' => 1,
        //         'country_code' => '+234',
        //         'role' => 1,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        //     [
        //         'name' => 'Israel Akinola',
        //         'phone' => '8166925166',
        //         'username' => 'israel',
        //         'email' => 'israelakinakinsanya@gmail.com',
        //         'password' => Hash::make('12345678'),
        //         'status' => 1,
        //         'country_code' => '+234',
        //         'role' => 2,
        //         'created_at' => now(),
        //         'updated_at' => noddw(),
        //     ],
        //     [
        //         'name' => 'Israel Akinola',
        //         'phone' => '8166925166',
        //         'username' => 'israel',
        //         'email' => 'israelakinola@gmail.com',
        //         'password' => Hash::make('12345678'),
        //         'status' => 1,
        //         'country_code' => '+234',
        //         'role' => 2,
        //         'created_at' => now(),
        //         'updated_at' => now(),
        //     ],
        // ]);
    }
}
