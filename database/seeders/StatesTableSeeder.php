<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class StatesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('local_states')->delete();

        \DB::table('local_states')->insert(array (
            0 =>
            array (
                'id' => 1,
                'name' => 'Abia',
            ),
            1 =>
            array (
                'id' => 2,
                'name' => 'Adamawa',
            ),
            2 =>
            array (
                'id' => 3,
                'name' => 'Akwa Ibom',
            ),
            3 =>
            array (
                'id' => 4,
                'name' => 'Anambra',
            ),
            4 =>
            array (
                'id' => 5,
                'name' => 'Bauchi',
            ),
            5 =>
            array (
                'id' => 6,
                'name' => 'Bayelsa',
            ),
            6 =>
            array (
                'id' => 7,
                'name' => 'Benue',
            ),
            7 =>
            array (
                'id' => 8,
                'name' => 'Borno',
            ),
            8 =>
            array (
                'id' => 9,
                'name' => 'Cross River',
            ),
            9 =>
            array (
                'id' => 10,
                'name' => 'Delta',
            ),
            10 =>
            array (
                'id' => 11,
                'name' => 'Ebonyi',
            ),
            11 =>
            array (
                'id' => 12,
                'name' => 'Edo',
            ),
            12 =>
            array (
                'id' => 13,
                'name' => 'Ekiti',
            ),
            13 =>
            array (
                'id' => 14,
                'name' => 'Enugu',
            ),
            14 =>
            array (
                'id' => 15,
                'name' => 'FCT',
            ),
            15 =>
            array (
                'id' => 16,
                'name' => 'Gombe',
            ),
            16 =>
            array (
                'id' => 17,
                'name' => 'Imo',
            ),
            17 =>
            array (
                'id' => 18,
                'name' => 'Jigawa',
            ),
            18 =>
            array (
                'id' => 19,
                'name' => 'Kaduna',
            ),
            19 =>
            array (
                'id' => 20,
                'name' => 'Kano',
            ),
            20 =>
            array (
                'id' => 21,
                'name' => 'Katsina',
            ),
            21 =>
            array (
                'id' => 22,
                'name' => 'Kebbi',
            ),
            22 =>
            array (
                'id' => 23,
                'name' => 'Kogi',
            ),
            23 =>
            array (
                'id' => 24,
                'name' => 'Kwara',
            ),
            24 =>
            array (
                'id' => 25,
                'name' => 'Lagos',
            ),
            25 =>
            array (
                'id' => 26,
                'name' => 'Nasarawa',
            ),
            26 =>
            array (
                'id' => 27,
                'name' => 'Niger',
            ),
            27 =>
            array (
                'id' => 28,
                'name' => 'Ogun',
            ),
            28 =>
            array (
                'id' => 29,
                'name' => 'Ondo',
            ),
            29 =>
            array (
                'id' => 30,
                'name' => 'Osun',
            ),
            30 =>
            array (
                'id' => 31,
                'name' => 'Oyo',
            ),
            31 =>
            array (
                'id' => 32,
                'name' => 'Plateau',
            ),
            32 =>
            array (
                'id' => 33,
                'name' => 'Rivers',
            ),
            33 =>
            array (
                'id' => 34,
                'name' => 'Sokoto',
            ),
            34 =>
            array (
                'id' => 35,
                'name' => 'Taraba',
            ),
            35 =>
            array (
                'id' => 36,
                'name' => 'Yobe',
            ),
            36 =>
            array (
                'id' => 37,
                'name' => 'Zamfara',
            ),
        ));


    }
}
