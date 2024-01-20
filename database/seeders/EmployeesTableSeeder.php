<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class EmployeesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('employees')->delete();
        
        \DB::table('employees')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => 'bb23e0a6-21f9-45a9-a61b-786cd1dc54c1',
                'full_name' => 'Pedro Wilderman',
                'address' => '5512 Lenora Flats',
                'phone_number' => '7566431162',
                'email' => 'sagnu1o33o@gufum.com',
                'department' => 'Health',
                'status' => 'Pending',
                'created_at' => '2024-01-20 10:26:20',
                'updated_at' => '2024-01-20 10:26:20',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}