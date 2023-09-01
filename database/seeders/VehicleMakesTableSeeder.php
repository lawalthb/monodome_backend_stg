<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VehicleMakesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vehicle_makes')->delete();
        
        \DB::table('vehicle_makes')->insert(array (
            0 => 
            array (
                'code' => 'ACURA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1,
                'logo' => NULL,
                'name' => 'Acura',
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'code' => 'ALFA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 2,
                'logo' => NULL,
                'name' => 'Alfa Romeo',
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'code' => 'AMC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 3,
                'logo' => NULL,
                'name' => 'AMC',
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'code' => 'ASTON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 4,
                'logo' => NULL,
                'name' => 'Aston Martin',
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'code' => 'AUDI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 5,
                'logo' => NULL,
                'name' => 'Audi',
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'code' => 'AVANTI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 6,
                'logo' => NULL,
                'name' => 'Avanti',
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'code' => 'BENTL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 7,
                'logo' => NULL,
                'name' => 'Bentley',
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'code' => 'BMW',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 8,
                'logo' => NULL,
                'name' => 'BMW',
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'code' => 'BUICK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 9,
                'logo' => NULL,
                'name' => 'Buick',
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'code' => 'CAD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 10,
                'logo' => NULL,
                'name' => 'Cadillac',
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'code' => 'CHEV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 11,
                'logo' => NULL,
                'name' => 'Chevrolet',
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'code' => 'CHRY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 12,
                'logo' => NULL,
                'name' => 'Chrysler',
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'code' => 'DAEW',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 13,
                'logo' => NULL,
                'name' => 'Daewoo',
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'code' => 'DAIHAT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 14,
                'logo' => NULL,
                'name' => 'Daihatsu',
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'code' => 'DATSUN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 15,
                'logo' => NULL,
                'name' => 'Datsun',
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'code' => 'DELOREAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 16,
                'logo' => NULL,
                'name' => 'DeLorean',
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'code' => 'DODGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 17,
                'logo' => NULL,
                'name' => 'Dodge',
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'code' => 'EAGLE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 18,
                'logo' => NULL,
                'name' => 'Eagle',
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'code' => 'FER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 19,
                'logo' => NULL,
                'name' => 'Ferrari',
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'code' => 'FIAT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 20,
                'logo' => NULL,
                'name' => 'FIAT',
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'code' => 'FISK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 21,
                'logo' => NULL,
                'name' => 'Fisker',
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'code' => 'FORD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 22,
                'logo' => NULL,
                'name' => 'Ford',
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'code' => 'FREIGHT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 23,
                'logo' => NULL,
                'name' => 'Freightliner',
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'code' => 'GEO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 24,
                'logo' => NULL,
                'name' => 'Geo',
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'code' => 'GMC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 25,
                'logo' => NULL,
                'name' => 'GMC',
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'code' => 'HONDA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 26,
                'logo' => NULL,
                'name' => 'Honda',
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'code' => 'AMGEN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 27,
                'logo' => NULL,
                'name' => 'HUMMER',
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'code' => 'HYUND',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 28,
                'logo' => NULL,
                'name' => 'Hyundai',
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'code' => 'INFIN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 29,
                'logo' => NULL,
                'name' => 'Infiniti',
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'code' => 'ISU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 30,
                'logo' => NULL,
                'name' => 'Isuzu',
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'code' => 'JAG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 31,
                'logo' => NULL,
                'name' => 'Jaguar',
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'code' => 'JEEP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 32,
                'logo' => NULL,
                'name' => 'Jeep',
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'code' => 'KIA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 33,
                'logo' => NULL,
                'name' => 'Kia',
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'code' => 'LAM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 34,
                'logo' => NULL,
                'name' => 'Lamborghini',
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'code' => 'LAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 35,
                'logo' => NULL,
                'name' => 'Lancia',
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'code' => 'ROV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 36,
                'logo' => NULL,
                'name' => 'Land Rover',
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'code' => 'LEXUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 37,
                'logo' => NULL,
                'name' => 'Lexus',
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'code' => 'LINC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 38,
                'logo' => NULL,
                'name' => 'Lincoln',
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'code' => 'LOTUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 39,
                'logo' => NULL,
                'name' => 'Lotus',
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'code' => 'MAS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 40,
                'logo' => NULL,
                'name' => 'Maserati',
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'code' => 'MAYBACH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 41,
                'logo' => NULL,
                'name' => 'Maybach',
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'code' => 'MAZDA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 42,
                'logo' => NULL,
                'name' => 'Mazda',
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'code' => 'MCLAREN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 43,
                'logo' => NULL,
                'name' => 'McLaren',
                'updated_at' => NULL,
            ),
            43 => 
            array (
                'code' => 'MB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 44,
                'logo' => NULL,
                'name' => 'Mercedes-Benz',
                'updated_at' => NULL,
            ),
            44 => 
            array (
                'code' => 'MERC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 45,
                'logo' => NULL,
                'name' => 'Mercury',
                'updated_at' => NULL,
            ),
            45 => 
            array (
                'code' => 'MERKUR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 46,
                'logo' => NULL,
                'name' => 'Merkur',
                'updated_at' => NULL,
            ),
            46 => 
            array (
                'code' => 'MINI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 47,
                'logo' => NULL,
                'name' => 'MINI',
                'updated_at' => NULL,
            ),
            47 => 
            array (
                'code' => 'MIT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 48,
                'logo' => NULL,
                'name' => 'Mitsubishi',
                'updated_at' => NULL,
            ),
            48 => 
            array (
                'code' => 'NISSAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 49,
                'logo' => NULL,
                'name' => 'Nissan',
                'updated_at' => NULL,
            ),
            49 => 
            array (
                'code' => 'OLDS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 50,
                'logo' => NULL,
                'name' => 'Oldsmobile',
                'updated_at' => NULL,
            ),
            50 => 
            array (
                'code' => 'PEUG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 51,
                'logo' => NULL,
                'name' => 'Peugeot',
                'updated_at' => NULL,
            ),
            51 => 
            array (
                'code' => 'PLYM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 52,
                'logo' => NULL,
                'name' => 'Plymouth',
                'updated_at' => NULL,
            ),
            52 => 
            array (
                'code' => 'PONT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 53,
                'logo' => NULL,
                'name' => 'Pontiac',
                'updated_at' => NULL,
            ),
            53 => 
            array (
                'code' => 'POR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 54,
                'logo' => NULL,
                'name' => 'Porsche',
                'updated_at' => NULL,
            ),
            54 => 
            array (
                'code' => 'RAM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 55,
                'logo' => NULL,
                'name' => 'RAM',
                'updated_at' => NULL,
            ),
            55 => 
            array (
                'code' => 'REN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 56,
                'logo' => NULL,
                'name' => 'Renault',
                'updated_at' => NULL,
            ),
            56 => 
            array (
                'code' => 'RR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 57,
                'logo' => NULL,
                'name' => 'Rolls-Royce',
                'updated_at' => NULL,
            ),
            57 => 
            array (
                'code' => 'SAAB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 58,
                'logo' => NULL,
                'name' => 'Saab',
                'updated_at' => NULL,
            ),
            58 => 
            array (
                'code' => 'SATURN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 59,
                'logo' => NULL,
                'name' => 'Saturn',
                'updated_at' => NULL,
            ),
            59 => 
            array (
                'code' => 'SCION',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 60,
                'logo' => NULL,
                'name' => 'Scion',
                'updated_at' => NULL,
            ),
            60 => 
            array (
                'code' => 'SMART',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 61,
                'logo' => NULL,
                'name' => 'smart',
                'updated_at' => NULL,
            ),
            61 => 
            array (
                'code' => 'SRT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 62,
                'logo' => NULL,
                'name' => 'SRT',
                'updated_at' => NULL,
            ),
            62 => 
            array (
                'code' => 'STERL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 63,
                'logo' => NULL,
                'name' => 'Sterling',
                'updated_at' => NULL,
            ),
            63 => 
            array (
                'code' => 'SUB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 64,
                'logo' => NULL,
                'name' => 'Subaru',
                'updated_at' => NULL,
            ),
            64 => 
            array (
                'code' => 'SUZUKI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 65,
                'logo' => NULL,
                'name' => 'Suzuki',
                'updated_at' => NULL,
            ),
            65 => 
            array (
                'code' => 'TESLA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 66,
                'logo' => NULL,
                'name' => 'Tesla',
                'updated_at' => NULL,
            ),
            66 => 
            array (
                'code' => 'TOYOTA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 67,
                'logo' => NULL,
                'name' => 'Toyota',
                'updated_at' => NULL,
            ),
            67 => 
            array (
                'code' => 'TRI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 68,
                'logo' => NULL,
                'name' => 'Triumph',
                'updated_at' => NULL,
            ),
            68 => 
            array (
                'code' => 'VOLKS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 69,
                'logo' => NULL,
                'name' => 'Volkswagen',
                'updated_at' => NULL,
            ),
            69 => 
            array (
                'code' => 'VOLVO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 70,
                'logo' => NULL,
                'name' => 'Volvo',
                'updated_at' => NULL,
            ),
            70 => 
            array (
                'code' => 'YUGO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 71,
                'logo' => NULL,
                'name' => 'Yugo',
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}