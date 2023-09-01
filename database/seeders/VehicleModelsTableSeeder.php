<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class VehicleModelsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('vehicle_models')->delete();
        
        \DB::table('vehicle_models')->insert(array (
            0 => 
            array (
                'code' => 'CL_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1,
            'name' => 'CL Models (4)',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            1 => 
            array (
                'code' => '2.2CL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 2,
                'name' => '2.2CL',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            2 => 
            array (
                'code' => '2.3CL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 3,
                'name' => '2.3CL',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            3 => 
            array (
                'code' => '3.0CL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 4,
                'name' => '3.0CL',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            4 => 
            array (
                'code' => '3.2CL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 5,
                'name' => '3.2CL',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            5 => 
            array (
                'code' => 'ILX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 6,
                'name' => 'ILX',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            6 => 
            array (
                'code' => 'INTEG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 7,
                'name' => 'Integra',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            7 => 
            array (
                'code' => 'LEGEND',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 8,
                'name' => 'Legend',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            8 => 
            array (
                'code' => 'MDX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 9,
                'name' => 'MDX',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            9 => 
            array (
                'code' => 'NSX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 10,
                'name' => 'NSX',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            10 => 
            array (
                'code' => 'RDX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 11,
                'name' => 'RDX',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            11 => 
            array (
                'code' => 'RL_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 12,
            'name' => 'RL Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            12 => 
            array (
                'code' => '3.5RL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 13,
                'name' => '3.5 RL',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            13 => 
            array (
                'code' => 'RL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 14,
                'name' => 'RL',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            14 => 
            array (
                'code' => 'RSX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 15,
                'name' => 'RSX',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            15 => 
            array (
                'code' => 'SLX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 16,
                'name' => 'SLX',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            16 => 
            array (
                'code' => 'TL_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 17,
            'name' => 'TL Models (3)',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            17 => 
            array (
                'code' => '2.5TL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 18,
                'name' => '2.5TL',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            18 => 
            array (
                'code' => '3.2TL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 19,
                'name' => '3.2TL',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            19 => 
            array (
                'code' => 'TL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 20,
                'name' => 'TL',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            20 => 
            array (
                'code' => 'TSX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 21,
                'name' => 'TSX',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            21 => 
            array (
                'code' => 'VIGOR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 22,
                'name' => 'Vigor',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            22 => 
            array (
                'code' => 'ZDX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 23,
                'name' => 'ZDX',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            23 => 
            array (
                'code' => 'ACUOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 24,
                'name' => 'Other Acura Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 1,
            ),
            24 => 
            array (
                'code' => 'ALFA164',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 25,
                'name' => '164',
                'updated_at' => NULL,
                'vehicle_make_id' => 2,
            ),
            25 => 
            array (
                'code' => 'ALFA8C',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 26,
                'name' => '8C Competizione',
                'updated_at' => NULL,
                'vehicle_make_id' => 2,
            ),
            26 => 
            array (
                'code' => 'ALFAGT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 27,
                'name' => 'GTV-6',
                'updated_at' => NULL,
                'vehicle_make_id' => 2,
            ),
            27 => 
            array (
                'code' => 'MIL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 28,
                'name' => 'Milano',
                'updated_at' => NULL,
                'vehicle_make_id' => 2,
            ),
            28 => 
            array (
                'code' => 'SPID',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 29,
                'name' => 'Spider',
                'updated_at' => NULL,
                'vehicle_make_id' => 2,
            ),
            29 => 
            array (
                'code' => 'ALFAOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 30,
                'name' => 'Other Alfa Romeo Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 2,
            ),
            30 => 
            array (
                'code' => 'AMCALLIAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 31,
                'name' => 'Alliance',
                'updated_at' => NULL,
                'vehicle_make_id' => 3,
            ),
            31 => 
            array (
                'code' => 'CON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 32,
                'name' => 'Concord',
                'updated_at' => NULL,
                'vehicle_make_id' => 3,
            ),
            32 => 
            array (
                'code' => 'EAGLE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 33,
                'name' => 'Eagle',
                'updated_at' => NULL,
                'vehicle_make_id' => 3,
            ),
            33 => 
            array (
                'code' => 'AMCENC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 34,
                'name' => 'Encore',
                'updated_at' => NULL,
                'vehicle_make_id' => 3,
            ),
            34 => 
            array (
                'code' => 'AMCSPIRIT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 35,
                'name' => 'Spirit',
                'updated_at' => NULL,
                'vehicle_make_id' => 3,
            ),
            35 => 
            array (
                'code' => 'AMCOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 36,
                'name' => 'Other AMC Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 3,
            ),
            36 => 
            array (
                'code' => 'DB7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 37,
                'name' => 'DB7',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            37 => 
            array (
                'code' => 'DB9',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 38,
                'name' => 'DB9',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            38 => 
            array (
                'code' => 'DBS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 39,
                'name' => 'DBS',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            39 => 
            array (
                'code' => 'LAGONDA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 40,
                'name' => 'Lagonda',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            40 => 
            array (
                'code' => 'RAPIDE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 41,
                'name' => 'Rapide',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            41 => 
            array (
                'code' => 'V12VANT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 42,
                'name' => 'V12 Vantage',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            42 => 
            array (
                'code' => 'VANTAGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 43,
                'name' => 'V8 Vantage',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            43 => 
            array (
                'code' => 'VANQUISH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 44,
                'name' => 'Vanquish',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            44 => 
            array (
                'code' => 'VIRAGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 45,
                'name' => 'Virage',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            45 => 
            array (
                'code' => 'UNAVAILAST',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 46,
                'name' => 'Other Aston Martin Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 4,
            ),
            46 => 
            array (
                'code' => 'AUDI100',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 47,
                'name' => '100',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            47 => 
            array (
                'code' => 'AUDI200',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 48,
                'name' => '200',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            48 => 
            array (
                'code' => '4000',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 49,
                'name' => '4000',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            49 => 
            array (
                'code' => '5000',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 50,
                'name' => '5000',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            50 => 
            array (
                'code' => '80',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 51,
                'name' => '80',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            51 => 
            array (
                'code' => '90',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 52,
                'name' => '90',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            52 => 
            array (
                'code' => 'A3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 53,
                'name' => 'A3',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            53 => 
            array (
                'code' => 'A4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 54,
                'name' => 'A4',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            54 => 
            array (
                'code' => 'A5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 55,
                'name' => 'A5',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            55 => 
            array (
                'code' => 'A6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 56,
                'name' => 'A6',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            56 => 
            array (
                'code' => 'A7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 57,
                'name' => 'A7',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            57 => 
            array (
                'code' => 'A8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 58,
                'name' => 'A8',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            58 => 
            array (
                'code' => 'ALLRDQUA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 59,
                'name' => 'allroad',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            59 => 
            array (
                'code' => 'AUDICABRI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 60,
                'name' => 'Cabriolet',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            60 => 
            array (
                'code' => 'AUDICOUPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 61,
                'name' => 'Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            61 => 
            array (
                'code' => 'Q3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 62,
                'name' => 'Q3',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            62 => 
            array (
                'code' => 'Q5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 63,
                'name' => 'Q5',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            63 => 
            array (
                'code' => 'Q7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 64,
                'name' => 'Q7',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            64 => 
            array (
                'code' => 'QUATTR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 65,
                'name' => 'Quattro',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            65 => 
            array (
                'code' => 'R8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 66,
                'name' => 'R8',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            66 => 
            array (
                'code' => 'RS4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 67,
                'name' => 'RS 4',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            67 => 
            array (
                'code' => 'RS5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 68,
                'name' => 'RS 5',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            68 => 
            array (
                'code' => 'RS6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 69,
                'name' => 'RS 6',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            69 => 
            array (
                'code' => 'S4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 70,
                'name' => 'S4',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            70 => 
            array (
                'code' => 'S5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 71,
                'name' => 'S5',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            71 => 
            array (
                'code' => 'S6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 72,
                'name' => 'S6',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            72 => 
            array (
                'code' => 'S7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 73,
                'name' => 'S7',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            73 => 
            array (
                'code' => 'S8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 74,
                'name' => 'S8',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            74 => 
            array (
                'code' => 'TT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 75,
                'name' => 'TT',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            75 => 
            array (
                'code' => 'TTRS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 76,
                'name' => 'TT RS',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            76 => 
            array (
                'code' => 'TTS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 77,
                'name' => 'TTS',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            77 => 
            array (
                'code' => 'V8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 78,
                'name' => 'V8 Quattro',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            78 => 
            array (
                'code' => 'AUDOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 79,
                'name' => 'Other Audi Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 5,
            ),
            79 => 
            array (
                'code' => 'CONVERT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 80,
                'name' => 'Convertible',
                'updated_at' => NULL,
                'vehicle_make_id' => 6,
            ),
            80 => 
            array (
                'code' => 'COUPEAVANT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 81,
                'name' => 'Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 6,
            ),
            81 => 
            array (
                'code' => 'SEDAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 82,
                'name' => 'Sedan',
                'updated_at' => NULL,
                'vehicle_make_id' => 6,
            ),
            82 => 
            array (
                'code' => 'UNAVAILAVA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 83,
                'name' => 'Other Avanti Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 6,
            ),
            83 => 
            array (
                'code' => 'ARNAGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 84,
                'name' => 'Arnage',
                'updated_at' => NULL,
                'vehicle_make_id' => 7,
            ),
            84 => 
            array (
                'code' => 'AZURE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 85,
                'name' => 'Azure',
                'updated_at' => NULL,
                'vehicle_make_id' => 7,
            ),
            85 => 
            array (
                'code' => 'BROOKLANDS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 86,
                'name' => 'Brooklands',
                'updated_at' => NULL,
                'vehicle_make_id' => 7,
            ),
            86 => 
            array (
                'code' => 'BENCONT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 87,
                'name' => 'Continental',
                'updated_at' => NULL,
                'vehicle_make_id' => 7,
            ),
            87 => 
            array (
                'code' => 'CORNICHE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 88,
                'name' => 'Corniche',
                'updated_at' => NULL,
                'vehicle_make_id' => 7,
            ),
            88 => 
            array (
                'code' => 'BENEIGHT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 89,
                'name' => 'Eight',
                'updated_at' => NULL,
                'vehicle_make_id' => 7,
            ),
            89 => 
            array (
                'code' => 'BENMUL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 90,
                'name' => 'Mulsanne',
                'updated_at' => NULL,
                'vehicle_make_id' => 7,
            ),
            90 => 
            array (
                'code' => 'BENTURBO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 91,
                'name' => 'Turbo R',
                'updated_at' => NULL,
                'vehicle_make_id' => 7,
            ),
            91 => 
            array (
                'code' => 'UNAVAILBEN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 92,
                'name' => 'Other Bentley Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 7,
            ),
            92 => 
            array (
                'code' => '1_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 93,
            'name' => '1 Series (3)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            93 => 
            array (
                'code' => '128I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 94,
                'name' => '128i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            94 => 
            array (
                'code' => '135I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 95,
                'name' => '135i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            95 => 
            array (
                'code' => '135IS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 96,
                'name' => '135is',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            96 => 
            array (
                'code' => '3_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 97,
            'name' => '3 Series (29)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            97 => 
            array (
                'code' => '318I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 98,
                'name' => '318i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            98 => 
            array (
                'code' => '318IC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 99,
                'name' => '318iC',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            99 => 
            array (
                'code' => '318IS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 100,
                'name' => '318iS',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            100 => 
            array (
                'code' => '318TI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 101,
                'name' => '318ti',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            101 => 
            array (
                'code' => '320I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 102,
                'name' => '320i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            102 => 
            array (
                'code' => '323CI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 103,
                'name' => '323ci',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            103 => 
            array (
                'code' => '323I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 104,
                'name' => '323i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            104 => 
            array (
                'code' => '323IS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 105,
                'name' => '323is',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            105 => 
            array (
                'code' => '323IT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 106,
                'name' => '323iT',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            106 => 
            array (
                'code' => '325CI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 107,
                'name' => '325Ci',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            107 => 
            array (
                'code' => '325E',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 108,
                'name' => '325e',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            108 => 
            array (
                'code' => '325ES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 109,
                'name' => '325es',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            109 => 
            array (
                'code' => '325I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 110,
                'name' => '325i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            110 => 
            array (
                'code' => '325IS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 111,
                'name' => '325is',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            111 => 
            array (
                'code' => '325IX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 112,
                'name' => '325iX',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            112 => 
            array (
                'code' => '325XI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 113,
                'name' => '325xi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            113 => 
            array (
                'code' => '328CI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 114,
                'name' => '328Ci',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            114 => 
            array (
                'code' => '328I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 115,
                'name' => '328i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            115 => 
            array (
                'code' => '328IS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 116,
                'name' => '328iS',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            116 => 
            array (
                'code' => '328XI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 117,
                'name' => '328xi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            117 => 
            array (
                'code' => '330CI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 118,
                'name' => '330Ci',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            118 => 
            array (
                'code' => '330I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 119,
                'name' => '330i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            119 => 
            array (
                'code' => '330XI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 120,
                'name' => '330xi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            120 => 
            array (
                'code' => '335D',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 121,
                'name' => '335d',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            121 => 
            array (
                'code' => '335I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 122,
                'name' => '335i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            122 => 
            array (
                'code' => '335IS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 123,
                'name' => '335is',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            123 => 
            array (
                'code' => '335XI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 124,
                'name' => '335xi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            124 => 
            array (
                'code' => 'ACTIVE3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 125,
                'name' => 'ActiveHybrid 3',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            125 => 
            array (
                'code' => 'BMW325',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 126,
                'name' => '325',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            126 => 
            array (
                'code' => '5_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 127,
            'name' => '5 Series (19)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            127 => 
            array (
                'code' => '524TD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 128,
                'name' => '524td',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            128 => 
            array (
                'code' => '525I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 129,
                'name' => '525i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            129 => 
            array (
                'code' => '525XI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 130,
                'name' => '525xi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            130 => 
            array (
                'code' => '528E',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 131,
                'name' => '528e',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            131 => 
            array (
                'code' => '528I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 132,
                'name' => '528i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            132 => 
            array (
                'code' => '528IT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 133,
                'name' => '528iT',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            133 => 
            array (
                'code' => '528XI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 134,
                'name' => '528xi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            134 => 
            array (
                'code' => '530I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 135,
                'name' => '530i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            135 => 
            array (
                'code' => '530IT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 136,
                'name' => '530iT',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            136 => 
            array (
                'code' => '530XI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 137,
                'name' => '530xi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            137 => 
            array (
                'code' => '533I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 138,
                'name' => '533i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            138 => 
            array (
                'code' => '535I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 139,
                'name' => '535i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            139 => 
            array (
                'code' => '535IGT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 140,
                'name' => '535i Gran Turismo',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            140 => 
            array (
                'code' => '535XI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 141,
                'name' => '535xi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            141 => 
            array (
                'code' => '540I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 142,
                'name' => '540i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            142 => 
            array (
                'code' => '545I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 143,
                'name' => '545i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            143 => 
            array (
                'code' => '550I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 144,
                'name' => '550i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            144 => 
            array (
                'code' => '550IGT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 145,
                'name' => '550i Gran Turismo',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            145 => 
            array (
                'code' => 'ACTIVE5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 146,
                'name' => 'ActiveHybrid 5',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            146 => 
            array (
                'code' => '6_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 147,
            'name' => '6 Series (8)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            147 => 
            array (
                'code' => '633CSI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 148,
                'name' => '633CSi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            148 => 
            array (
                'code' => '635CSI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 149,
                'name' => '635CSi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            149 => 
            array (
                'code' => '640I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 150,
                'name' => '640i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            150 => 
            array (
                'code' => '640IGC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 151,
                'name' => '640i Gran Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            151 => 
            array (
                'code' => '645CI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 152,
                'name' => '645Ci',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            152 => 
            array (
                'code' => '650I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 153,
                'name' => '650i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            153 => 
            array (
                'code' => '650IGC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 154,
                'name' => '650i Gran Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            154 => 
            array (
                'code' => 'L6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 155,
                'name' => 'L6',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            155 => 
            array (
                'code' => '7_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 156,
            'name' => '7 Series (15)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            156 => 
            array (
                'code' => '733I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 157,
                'name' => '733i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            157 => 
            array (
                'code' => '735I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 158,
                'name' => '735i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            158 => 
            array (
                'code' => '735IL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 159,
                'name' => '735iL',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            159 => 
            array (
                'code' => '740I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 160,
                'name' => '740i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            160 => 
            array (
                'code' => '740IL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 161,
                'name' => '740iL',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            161 => 
            array (
                'code' => '740LI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 162,
                'name' => '740Li',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            162 => 
            array (
                'code' => '745I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 163,
                'name' => '745i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            163 => 
            array (
                'code' => '745LI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 164,
                'name' => '745Li',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            164 => 
            array (
                'code' => '750I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 165,
                'name' => '750i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            165 => 
            array (
                'code' => '750IL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 166,
                'name' => '750iL',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            166 => 
            array (
                'code' => '750LI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 167,
                'name' => '750Li',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            167 => 
            array (
                'code' => '760I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 168,
                'name' => '760i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            168 => 
            array (
                'code' => '760LI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 169,
                'name' => '760Li',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            169 => 
            array (
                'code' => 'ACTIVE7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 170,
                'name' => 'ActiveHybrid 7',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            170 => 
            array (
                'code' => 'ALPINAB7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 171,
                'name' => 'Alpina B7',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            171 => 
            array (
                'code' => '8_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 172,
            'name' => '8 Series (4)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            172 => 
            array (
                'code' => '840CI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 173,
                'name' => '840Ci',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            173 => 
            array (
                'code' => '850CI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 174,
                'name' => '850Ci',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            174 => 
            array (
                'code' => '850CSI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 175,
                'name' => '850CSi',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            175 => 
            array (
                'code' => '850I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 176,
                'name' => '850i',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            176 => 
            array (
                'code' => 'L_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 177,
            'name' => 'L Series (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            177 => 
            array (
                'code' => 'L7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 178,
                'name' => 'L7',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            178 => 
            array (
                'code' => 'M_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 179,
            'name' => 'M Series (8)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            179 => 
            array (
                'code' => '1SERIESM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 180,
                'name' => '1 Series M',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            180 => 
            array (
                'code' => 'BMWMCOUPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 181,
                'name' => 'M Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            181 => 
            array (
                'code' => 'BMWROAD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 182,
                'name' => 'M Roadster',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            182 => 
            array (
                'code' => 'M3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 183,
                'name' => 'M3',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            183 => 
            array (
                'code' => 'M5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 184,
                'name' => 'M5',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            184 => 
            array (
                'code' => 'M6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 185,
                'name' => 'M6',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            185 => 
            array (
                'code' => 'X5M',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 186,
                'name' => 'X5 M',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            186 => 
            array (
                'code' => 'X6M',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 187,
                'name' => 'X6 M',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            187 => 
            array (
                'code' => 'X_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 188,
            'name' => 'X Series (5)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            188 => 
            array (
                'code' => 'ACTIVEX6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 189,
                'name' => 'ActiveHybrid X6',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            189 => 
            array (
                'code' => 'X1',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 190,
                'name' => 'X1',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            190 => 
            array (
                'code' => 'X3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 191,
                'name' => 'X3',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            191 => 
            array (
                'code' => 'X5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 192,
                'name' => 'X5',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            192 => 
            array (
                'code' => 'X6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 193,
                'name' => 'X6',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            193 => 
            array (
                'code' => 'Z_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 194,
            'name' => 'Z Series (3)',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            194 => 
            array (
                'code' => 'Z3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 195,
                'name' => 'Z3',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            195 => 
            array (
                'code' => 'Z4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 196,
                'name' => 'Z4',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            196 => 
            array (
                'code' => 'Z8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 197,
                'name' => 'Z8',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            197 => 
            array (
                'code' => 'BMWOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 198,
                'name' => 'Other BMW Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 8,
            ),
            198 => 
            array (
                'code' => 'CENT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 199,
                'name' => 'Century',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            199 => 
            array (
                'code' => 'ELEC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 200,
                'name' => 'Electra',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            200 => 
            array (
                'code' => 'ENCLAVE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 201,
                'name' => 'Enclave',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            201 => 
            array (
                'code' => 'BUIENC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 202,
                'name' => 'Encore',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            202 => 
            array (
                'code' => 'LACROSSE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 203,
                'name' => 'LaCrosse',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            203 => 
            array (
                'code' => 'LESA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 204,
                'name' => 'Le Sabre',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            204 => 
            array (
                'code' => 'LUCERNE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 205,
                'name' => 'Lucerne',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            205 => 
            array (
                'code' => 'PARK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 206,
                'name' => 'Park Avenue',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            206 => 
            array (
                'code' => 'RAINIER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 207,
                'name' => 'Rainier',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            207 => 
            array (
                'code' => 'REATTA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 208,
                'name' => 'Reatta',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            208 => 
            array (
                'code' => 'REG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 209,
                'name' => 'Regal',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            209 => 
            array (
                'code' => 'RENDEZVOUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 210,
                'name' => 'Rendezvous',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            210 => 
            array (
                'code' => 'RIV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 211,
                'name' => 'Riviera',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            211 => 
            array (
                'code' => 'BUICKROAD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 212,
                'name' => 'Roadmaster',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            212 => 
            array (
                'code' => 'SKYH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 213,
                'name' => 'Skyhawk',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            213 => 
            array (
                'code' => 'SKYL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 214,
                'name' => 'Skylark',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            214 => 
            array (
                'code' => 'SOMER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 215,
                'name' => 'Somerset',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            215 => 
            array (
                'code' => 'TERRAZA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 216,
                'name' => 'Terraza',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            216 => 
            array (
                'code' => 'BUVERANO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 217,
                'name' => 'Verano',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            217 => 
            array (
                'code' => 'BUOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 218,
                'name' => 'Other Buick Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 9,
            ),
            218 => 
            array (
                'code' => 'ALLANT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 219,
                'name' => 'Allante',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            219 => 
            array (
                'code' => 'ATS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 220,
                'name' => 'ATS',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            220 => 
            array (
                'code' => 'BROUGH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 221,
                'name' => 'Brougham',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            221 => 
            array (
                'code' => 'CATERA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 222,
                'name' => 'Catera',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            222 => 
            array (
                'code' => 'CIMA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 223,
                'name' => 'Cimarron',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            223 => 
            array (
                'code' => 'CTS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 224,
                'name' => 'CTS',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            224 => 
            array (
                'code' => 'DEV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 225,
                'name' => 'De Ville',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            225 => 
            array (
                'code' => 'DTS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 226,
                'name' => 'DTS',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            226 => 
            array (
                'code' => 'ELDO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 227,
                'name' => 'Eldorado',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            227 => 
            array (
                'code' => 'ESCALA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 228,
                'name' => 'Escalade',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            228 => 
            array (
                'code' => 'ESCALAESV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 229,
                'name' => 'Escalade ESV',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            229 => 
            array (
                'code' => 'EXT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 230,
                'name' => 'Escalade EXT',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            230 => 
            array (
                'code' => 'FLEE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 231,
                'name' => 'Fleetwood',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            231 => 
            array (
                'code' => 'SEV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 232,
                'name' => 'Seville',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            232 => 
            array (
                'code' => 'SRX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 233,
                'name' => 'SRX',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            233 => 
            array (
                'code' => 'STS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 234,
                'name' => 'STS',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            234 => 
            array (
                'code' => 'XLR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 235,
                'name' => 'XLR',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            235 => 
            array (
                'code' => 'XTS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 236,
                'name' => 'XTS',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            236 => 
            array (
                'code' => 'CADOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 237,
                'name' => 'Other Cadillac Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 10,
            ),
            237 => 
            array (
                'code' => 'ASTRO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 238,
                'name' => 'Astro',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            238 => 
            array (
                'code' => 'AVALNCH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 239,
                'name' => 'Avalanche',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            239 => 
            array (
                'code' => 'AVEO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 240,
                'name' => 'Aveo',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            240 => 
            array (
                'code' => 'AVEO5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 241,
                'name' => 'Aveo5',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            241 => 
            array (
                'code' => 'BERETT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 242,
                'name' => 'Beretta',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            242 => 
            array (
                'code' => 'BLAZER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 243,
                'name' => 'Blazer',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            243 => 
            array (
                'code' => 'CAM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 244,
                'name' => 'Camaro',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            244 => 
            array (
                'code' => 'CAP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 245,
                'name' => 'Caprice',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            245 => 
            array (
                'code' => 'CHECAPS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 246,
                'name' => 'Captiva Sport',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            246 => 
            array (
                'code' => 'CAV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 247,
                'name' => 'Cavalier',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            247 => 
            array (
                'code' => 'CELE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 248,
                'name' => 'Celebrity',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            248 => 
            array (
                'code' => 'CHEVETTE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 249,
                'name' => 'Chevette',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            249 => 
            array (
                'code' => 'CITATION',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 250,
                'name' => 'Citation',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            250 => 
            array (
                'code' => 'COBALT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 251,
                'name' => 'Cobalt',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            251 => 
            array (
                'code' => 'COLORADO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 252,
                'name' => 'Colorado',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            252 => 
            array (
                'code' => 'CORSI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 253,
                'name' => 'Corsica',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            253 => 
            array (
                'code' => 'CORV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 254,
                'name' => 'Corvette',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            254 => 
            array (
                'code' => 'CRUZE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 255,
                'name' => 'Cruze',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            255 => 
            array (
                'code' => 'ELCAM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 256,
                'name' => 'El Camino',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            256 => 
            array (
                'code' => 'EQUINOX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 257,
                'name' => 'Equinox',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            257 => 
            array (
                'code' => 'G15EXP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 258,
                'name' => 'Express Van',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            258 => 
            array (
                'code' => 'G10',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 259,
                'name' => 'G Van',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            259 => 
            array (
                'code' => 'HHR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 260,
                'name' => 'HHR',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            260 => 
            array (
                'code' => 'CHEVIMP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 261,
                'name' => 'Impala',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            261 => 
            array (
                'code' => 'KODC4500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 262,
                'name' => 'Kodiak C4500',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            262 => 
            array (
                'code' => 'LUMINA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 263,
                'name' => 'Lumina',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            263 => 
            array (
                'code' => 'LAPV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 264,
                'name' => 'Lumina APV',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            264 => 
            array (
                'code' => 'LUV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 265,
                'name' => 'LUV',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            265 => 
            array (
                'code' => 'MALI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 266,
                'name' => 'Malibu',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            266 => 
            array (
                'code' => 'CHVMETR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 267,
                'name' => 'Metro',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            267 => 
            array (
                'code' => 'CHEVMONT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 268,
                'name' => 'Monte Carlo',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            268 => 
            array (
                'code' => 'NOVA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 269,
                'name' => 'Nova',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            269 => 
            array (
                'code' => 'CHEVPRIZM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 270,
                'name' => 'Prizm',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            270 => 
            array (
                'code' => 'CHVST',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 271,
                'name' => 'S10 Blazer',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            271 => 
            array (
                'code' => 'S10PICKUP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 272,
                'name' => 'S10 Pickup',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            272 => 
            array (
                'code' => 'CHEV150',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 273,
                'name' => 'Silverado and other C/K1500',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            273 => 
            array (
                'code' => 'CHEVC25',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 274,
                'name' => 'Silverado and other C/K2500',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            274 => 
            array (
                'code' => 'CH3500PU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 275,
                'name' => 'Silverado and other C/K3500',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            275 => 
            array (
                'code' => 'SONIC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 276,
                'name' => 'Sonic',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            276 => 
            array (
                'code' => 'SPARK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 277,
                'name' => 'Spark',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            277 => 
            array (
                'code' => 'CHEVSPEC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 278,
                'name' => 'Spectrum',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            278 => 
            array (
                'code' => 'CHSPRINT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 279,
                'name' => 'Sprint',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            279 => 
            array (
                'code' => 'SSR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 280,
                'name' => 'SSR',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            280 => 
            array (
                'code' => 'CHEVSUB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 281,
                'name' => 'Suburban',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            281 => 
            array (
                'code' => 'TAHOE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 282,
                'name' => 'Tahoe',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            282 => 
            array (
                'code' => 'TRACKE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 283,
                'name' => 'Tracker',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            283 => 
            array (
                'code' => 'TRAILBLZ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 284,
                'name' => 'TrailBlazer',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            284 => 
            array (
                'code' => 'TRAILBZEXT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 285,
                'name' => 'TrailBlazer EXT',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            285 => 
            array (
                'code' => 'TRAVERSE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 286,
                'name' => 'Traverse',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            286 => 
            array (
                'code' => 'UPLANDER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 287,
                'name' => 'Uplander',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            287 => 
            array (
                'code' => 'VENTUR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 288,
                'name' => 'Venture',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            288 => 
            array (
                'code' => 'VOLT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 289,
                'name' => 'Volt',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            289 => 
            array (
                'code' => 'CHEOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 290,
                'name' => 'Other Chevrolet Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 11,
            ),
            290 => 
            array (
                'code' => 'CHRYS200',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 291,
                'name' => '200',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            291 => 
            array (
                'code' => '300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 292,
                'name' => '300',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            292 => 
            array (
                'code' => 'CHRY300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 293,
                'name' => '300M',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            293 => 
            array (
                'code' => 'ASPEN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 294,
                'name' => 'Aspen',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            294 => 
            array (
                'code' => 'CARAVAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 295,
                'name' => 'Caravan',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            295 => 
            array (
                'code' => 'CIRRUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 296,
                'name' => 'Cirrus',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            296 => 
            array (
                'code' => 'CONC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 297,
                'name' => 'Concorde',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            297 => 
            array (
                'code' => 'CHRYCONQ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 298,
                'name' => 'Conquest',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            298 => 
            array (
                'code' => 'CORDOBA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 299,
                'name' => 'Cordoba',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            299 => 
            array (
                'code' => 'CROSSFIRE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 300,
                'name' => 'Crossfire',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            300 => 
            array (
                'code' => 'ECLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 301,
                'name' => 'E Class',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            301 => 
            array (
                'code' => 'FIFTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 302,
                'name' => 'Fifth Avenue',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            302 => 
            array (
                'code' => 'CHRYGRANDV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 303,
                'name' => 'Grand Voyager',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            303 => 
            array (
                'code' => 'IMPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 304,
                'name' => 'Imperial',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            304 => 
            array (
                'code' => 'INTREPID',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 305,
                'name' => 'Intrepid',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            305 => 
            array (
                'code' => 'CHRYLAS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 306,
                'name' => 'Laser',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            306 => 
            array (
                'code' => 'LEBA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 307,
                'name' => 'LeBaron',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            307 => 
            array (
                'code' => 'LHS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 308,
                'name' => 'LHS',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            308 => 
            array (
                'code' => 'CHRYNEON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 309,
                'name' => 'Neon',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            309 => 
            array (
                'code' => 'NY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 310,
                'name' => 'New Yorker',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            310 => 
            array (
                'code' => 'NEWPORT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 311,
                'name' => 'Newport',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            311 => 
            array (
                'code' => 'PACIFICA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 312,
                'name' => 'Pacifica',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            312 => 
            array (
                'code' => 'CHPROWLE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 313,
                'name' => 'Prowler',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            313 => 
            array (
                'code' => 'PTCRUIS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 314,
                'name' => 'PT Cruiser',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            314 => 
            array (
                'code' => 'CHRYSEB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 315,
                'name' => 'Sebring',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            315 => 
            array (
                'code' => 'CHRYTC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 316,
                'name' => 'TC by Maserati',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            316 => 
            array (
                'code' => 'TANDC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 317,
                'name' => 'Town & Country',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            317 => 
            array (
                'code' => 'VOYAGER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 318,
                'name' => 'Voyager',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            318 => 
            array (
                'code' => 'CHOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 319,
                'name' => 'Other Chrysler Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 12,
            ),
            319 => 
            array (
                'code' => 'LANOS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 320,
                'name' => 'Lanos',
                'updated_at' => NULL,
                'vehicle_make_id' => 13,
            ),
            320 => 
            array (
                'code' => 'LEGANZA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 321,
                'name' => 'Leganza',
                'updated_at' => NULL,
                'vehicle_make_id' => 13,
            ),
            321 => 
            array (
                'code' => 'NUBIRA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 322,
                'name' => 'Nubira',
                'updated_at' => NULL,
                'vehicle_make_id' => 13,
            ),
            322 => 
            array (
                'code' => 'DAEOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 323,
                'name' => 'Other Daewoo Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 13,
            ),
            323 => 
            array (
                'code' => 'CHAR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 324,
                'name' => 'Charade',
                'updated_at' => NULL,
                'vehicle_make_id' => 14,
            ),
            324 => 
            array (
                'code' => 'ROCKY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 325,
                'name' => 'Rocky',
                'updated_at' => NULL,
                'vehicle_make_id' => 14,
            ),
            325 => 
            array (
                'code' => 'DAIHOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 326,
                'name' => 'Other Daihatsu Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 14,
            ),
            326 => 
            array (
                'code' => 'DAT200SX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 327,
                'name' => '200SX',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            327 => 
            array (
                'code' => 'DAT210',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 328,
                'name' => '210',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            328 => 
            array (
                'code' => '280Z',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 329,
                'name' => '280ZX',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            329 => 
            array (
                'code' => '300ZX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 330,
                'name' => '300ZX',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            330 => 
            array (
                'code' => '310',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 331,
                'name' => '310',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            331 => 
            array (
                'code' => '510',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 332,
                'name' => '510',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            332 => 
            array (
                'code' => '720',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 333,
                'name' => '720',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            333 => 
            array (
                'code' => '810',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 334,
                'name' => '810',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            334 => 
            array (
                'code' => 'DATMAX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 335,
                'name' => 'Maxima',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            335 => 
            array (
                'code' => 'DATPU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 336,
                'name' => 'Pickup',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            336 => 
            array (
                'code' => 'PUL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 337,
                'name' => 'Pulsar',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            337 => 
            array (
                'code' => 'DATSENT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 338,
                'name' => 'Sentra',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            338 => 
            array (
                'code' => 'STAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 339,
                'name' => 'Stanza',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            339 => 
            array (
                'code' => 'DATOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 340,
                'name' => 'Other Datsun Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 15,
            ),
            340 => 
            array (
                'code' => 'DMC12',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 341,
                'name' => 'DMC-12',
                'updated_at' => NULL,
                'vehicle_make_id' => 16,
            ),
            341 => 
            array (
                'code' => '400',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 342,
                'name' => '400',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            342 => 
            array (
                'code' => 'DOD600',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 343,
                'name' => '600',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            343 => 
            array (
                'code' => 'ARI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 344,
                'name' => 'Aries',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            344 => 
            array (
                'code' => 'AVENGR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 345,
                'name' => 'Avenger',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            345 => 
            array (
                'code' => 'CALIBER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 346,
                'name' => 'Caliber',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            346 => 
            array (
                'code' => 'DODCARA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 347,
                'name' => 'Caravan',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            347 => 
            array (
                'code' => 'CHALLENGER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 348,
                'name' => 'Challenger',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            348 => 
            array (
                'code' => 'DODCHAR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 349,
                'name' => 'Charger',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            349 => 
            array (
                'code' => 'DODCOLT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 350,
                'name' => 'Colt',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            350 => 
            array (
                'code' => 'DODCONQ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 351,
                'name' => 'Conquest',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            351 => 
            array (
                'code' => 'DODDW',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 352,
                'name' => 'D/W Truck',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            352 => 
            array (
                'code' => 'DAKOTA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 353,
                'name' => 'Dakota',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            353 => 
            array (
                'code' => 'DODDART',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 354,
                'name' => 'Dart',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            354 => 
            array (
                'code' => 'DAY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 355,
                'name' => 'Daytona',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            355 => 
            array (
                'code' => 'DIPLOMA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 356,
                'name' => 'Diplomat',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            356 => 
            array (
                'code' => 'DURANG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 357,
                'name' => 'Durango',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            357 => 
            array (
                'code' => 'DODDYNA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 358,
                'name' => 'Dynasty',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            358 => 
            array (
                'code' => 'GRANDCARAV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 359,
                'name' => 'Grand Caravan',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            359 => 
            array (
                'code' => 'INTRE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 360,
                'name' => 'Intrepid',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            360 => 
            array (
                'code' => 'JOURNEY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 361,
                'name' => 'Journey',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            361 => 
            array (
                'code' => 'LANCERDODG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 362,
                'name' => 'Lancer',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            362 => 
            array (
                'code' => 'MAGNUM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 363,
                'name' => 'Magnum',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            363 => 
            array (
                'code' => 'MIRADA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 364,
                'name' => 'Mirada',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            364 => 
            array (
                'code' => 'MONACO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 365,
                'name' => 'Monaco',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            365 => 
            array (
                'code' => 'DODNEON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 366,
                'name' => 'Neon',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            366 => 
            array (
                'code' => 'NITRO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 367,
                'name' => 'Nitro',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            367 => 
            array (
                'code' => 'OMNI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 368,
                'name' => 'Omni',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            368 => 
            array (
                'code' => 'RAIDER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 369,
                'name' => 'Raider',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            369 => 
            array (
                'code' => 'RAM1504WD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 370,
                'name' => 'Ram 1500 Truck',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            370 => 
            array (
                'code' => 'RAM25002WD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 371,
                'name' => 'Ram 2500 Truck',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            371 => 
            array (
                'code' => 'RAM3502WD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 372,
                'name' => 'Ram 3500 Truck',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            372 => 
            array (
                'code' => 'RAM4500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 373,
                'name' => 'Ram 4500 Truck',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            373 => 
            array (
                'code' => 'DODD50',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 374,
                'name' => 'Ram 50 Truck',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            374 => 
            array (
                'code' => 'CV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 375,
                'name' => 'RAM C/V',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            375 => 
            array (
                'code' => 'RAMSRT10',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 376,
                'name' => 'Ram SRT-10',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            376 => 
            array (
                'code' => 'RAMVANV8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 377,
                'name' => 'Ram Van',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            377 => 
            array (
                'code' => 'RAMWAGON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 378,
                'name' => 'Ram Wagon',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            378 => 
            array (
                'code' => 'RAMCGR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 379,
                'name' => 'Ramcharger',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            379 => 
            array (
                'code' => 'RAMPAGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 380,
                'name' => 'Rampage',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            380 => 
            array (
                'code' => 'DODSHAD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 381,
                'name' => 'Shadow',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            381 => 
            array (
                'code' => 'DODSPIR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 382,
                'name' => 'Spirit',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            382 => 
            array (
                'code' => 'SPRINTER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 383,
                'name' => 'Sprinter',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            383 => 
            array (
                'code' => 'SRT4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 384,
                'name' => 'SRT-4',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            384 => 
            array (
                'code' => 'STREGIS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 385,
                'name' => 'St. Regis',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            385 => 
            array (
                'code' => 'STEAL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 386,
                'name' => 'Stealth',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            386 => 
            array (
                'code' => 'STRATU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 387,
                'name' => 'Stratus',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            387 => 
            array (
                'code' => 'VIPER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 388,
                'name' => 'Viper',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            388 => 
            array (
                'code' => 'DOOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 389,
                'name' => 'Other Dodge Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 17,
            ),
            389 => 
            array (
                'code' => 'EAGLEMED',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 390,
                'name' => 'Medallion',
                'updated_at' => NULL,
                'vehicle_make_id' => 18,
            ),
            390 => 
            array (
                'code' => 'EAGLEPREM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 391,
                'name' => 'Premier',
                'updated_at' => NULL,
                'vehicle_make_id' => 18,
            ),
            391 => 
            array (
                'code' => 'SUMMIT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 392,
                'name' => 'Summit',
                'updated_at' => NULL,
                'vehicle_make_id' => 18,
            ),
            392 => 
            array (
                'code' => 'TALON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 393,
                'name' => 'Talon',
                'updated_at' => NULL,
                'vehicle_make_id' => 18,
            ),
            393 => 
            array (
                'code' => 'VISION',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 394,
                'name' => 'Vision',
                'updated_at' => NULL,
                'vehicle_make_id' => 18,
            ),
            394 => 
            array (
                'code' => 'EAGOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 395,
                'name' => 'Other Eagle Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 18,
            ),
            395 => 
            array (
                'code' => '308GTB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 396,
                'name' => '308 GTB Quattrovalvole',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            396 => 
            array (
                'code' => '308TBI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 397,
                'name' => '308 GTBI',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            397 => 
            array (
                'code' => '308GTS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 398,
                'name' => '308 GTS Quattrovalvole',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            398 => 
            array (
                'code' => '308TSI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 399,
                'name' => '308 GTSI',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            399 => 
            array (
                'code' => '328GTB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 400,
                'name' => '328 GTB',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            400 => 
            array (
                'code' => '328GTS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 401,
                'name' => '328 GTS',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            401 => 
            array (
                'code' => '348GTB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 402,
                'name' => '348 GTB',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            402 => 
            array (
                'code' => '348GTS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 403,
                'name' => '348 GTS',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            403 => 
            array (
                'code' => '348SPI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 404,
                'name' => '348 Spider',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            404 => 
            array (
                'code' => '348TB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 405,
                'name' => '348 TB',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            405 => 
            array (
                'code' => '348TS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 406,
                'name' => '348 TS',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            406 => 
            array (
                'code' => '360',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 407,
                'name' => '360',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            407 => 
            array (
                'code' => '456GT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 408,
                'name' => '456 GT',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            408 => 
            array (
                'code' => '456MGT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 409,
                'name' => '456M GT',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            409 => 
            array (
                'code' => '458ITALIA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 410,
                'name' => '458 Italia',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            410 => 
            array (
                'code' => '512BBI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 411,
                'name' => '512 BBi',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            411 => 
            array (
                'code' => '512M',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 412,
                'name' => '512M',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            412 => 
            array (
                'code' => '512TR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 413,
                'name' => '512TR',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            413 => 
            array (
                'code' => '550M',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 414,
                'name' => '550 Maranello',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            414 => 
            array (
                'code' => '575M',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 415,
                'name' => '575M Maranello',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            415 => 
            array (
                'code' => '599GTB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 416,
                'name' => '599 GTB Fiorano',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            416 => 
            array (
                'code' => '599GTO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 417,
                'name' => '599 GTO',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            417 => 
            array (
                'code' => '612SCAGLIE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 418,
                'name' => '612 Scaglietti',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            418 => 
            array (
                'code' => 'FERCALIF',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 419,
                'name' => 'California',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            419 => 
            array (
                'code' => 'ENZO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 420,
                'name' => 'Enzo',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            420 => 
            array (
                'code' => 'F355',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 421,
                'name' => 'F355',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            421 => 
            array (
                'code' => 'F40',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 422,
                'name' => 'F40',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            422 => 
            array (
                'code' => 'F430',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 423,
                'name' => 'F430',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            423 => 
            array (
                'code' => 'F50',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 424,
                'name' => 'F50',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            424 => 
            array (
                'code' => 'FERFF',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 425,
                'name' => 'FF',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            425 => 
            array (
                'code' => 'MOND',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 426,
                'name' => 'Mondial',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            426 => 
            array (
                'code' => 'TEST',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 427,
                'name' => 'Testarossa',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            427 => 
            array (
                'code' => 'UNAVAILFER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 428,
                'name' => 'Other Ferrari Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 19,
            ),
            428 => 
            array (
                'code' => '2000',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 429,
                'name' => '2000 Spider',
                'updated_at' => NULL,
                'vehicle_make_id' => 20,
            ),
            429 => 
            array (
                'code' => 'FIAT500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 430,
                'name' => '500',
                'updated_at' => NULL,
                'vehicle_make_id' => 20,
            ),
            430 => 
            array (
                'code' => 'BERTON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 431,
                'name' => 'Bertone X1/9',
                'updated_at' => NULL,
                'vehicle_make_id' => 20,
            ),
            431 => 
            array (
                'code' => 'BRAVA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 432,
                'name' => 'Brava',
                'updated_at' => NULL,
                'vehicle_make_id' => 20,
            ),
            432 => 
            array (
                'code' => 'PININ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 433,
                'name' => 'Pininfarina Spider',
                'updated_at' => NULL,
                'vehicle_make_id' => 20,
            ),
            433 => 
            array (
                'code' => 'STRADA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 434,
                'name' => 'Strada',
                'updated_at' => NULL,
                'vehicle_make_id' => 20,
            ),
            434 => 
            array (
                'code' => 'FIATX19',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 435,
                'name' => 'X1/9',
                'updated_at' => NULL,
                'vehicle_make_id' => 20,
            ),
            435 => 
            array (
                'code' => 'UNAVAILFIA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 436,
                'name' => 'Other Fiat Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 20,
            ),
            436 => 
            array (
                'code' => 'KARMA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 437,
                'name' => 'Karma',
                'updated_at' => NULL,
                'vehicle_make_id' => 21,
            ),
            437 => 
            array (
                'code' => 'AERO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 438,
                'name' => 'Aerostar',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            438 => 
            array (
                'code' => 'ASPIRE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 439,
                'name' => 'Aspire',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            439 => 
            array (
                'code' => 'BRON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 440,
                'name' => 'Bronco',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            440 => 
            array (
                'code' => 'B2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 441,
                'name' => 'Bronco II',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            441 => 
            array (
                'code' => 'FOCMAX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 442,
                'name' => 'C-MAX',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            442 => 
            array (
                'code' => 'FORDCLUB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 443,
                'name' => 'Club Wagon',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            443 => 
            array (
                'code' => 'CONTOUR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 444,
                'name' => 'Contour',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            444 => 
            array (
                'code' => 'COURIER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 445,
                'name' => 'Courier',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            445 => 
            array (
                'code' => 'CROWNVIC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 446,
                'name' => 'Crown Victoria',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            446 => 
            array (
                'code' => 'E150ECON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 447,
                'name' => 'E-150 and Econoline 150',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            447 => 
            array (
                'code' => 'E250ECON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 448,
                'name' => 'E-250 and Econoline 250',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            448 => 
            array (
                'code' => 'E350ECON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 449,
                'name' => 'E-350 and Econoline 350',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            449 => 
            array (
                'code' => 'EDGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 450,
                'name' => 'Edge',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            450 => 
            array (
                'code' => 'ESCAPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 451,
                'name' => 'Escape',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            451 => 
            array (
                'code' => 'ESCO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 452,
                'name' => 'Escort',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            452 => 
            array (
                'code' => 'EXCURSION',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 453,
                'name' => 'Excursion',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            453 => 
            array (
                'code' => 'EXP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 454,
                'name' => 'EXP',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            454 => 
            array (
                'code' => 'EXPEDI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 455,
                'name' => 'Expedition',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            455 => 
            array (
                'code' => 'EXPEDIEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 456,
                'name' => 'Expedition EL',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            456 => 
            array (
                'code' => 'EXPLOR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 457,
                'name' => 'Explorer',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            457 => 
            array (
                'code' => 'SPORTTRAC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 458,
                'name' => 'Explorer Sport Trac',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            458 => 
            array (
                'code' => 'F100',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 459,
                'name' => 'F100',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            459 => 
            array (
                'code' => 'F150PICKUP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 460,
                'name' => 'F150',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            460 => 
            array (
                'code' => 'F250',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 461,
                'name' => 'F250',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            461 => 
            array (
                'code' => 'F350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 462,
                'name' => 'F350',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            462 => 
            array (
                'code' => 'F450',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 463,
                'name' => 'F450',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            463 => 
            array (
                'code' => 'FAIRM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 464,
                'name' => 'Fairmont',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            464 => 
            array (
                'code' => 'FESTIV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 465,
                'name' => 'Festiva',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            465 => 
            array (
                'code' => 'FIESTA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 466,
                'name' => 'Fiesta',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            466 => 
            array (
                'code' => 'FIVEHUNDRE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 467,
                'name' => 'Five Hundred',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            467 => 
            array (
                'code' => 'FLEX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 468,
                'name' => 'Flex',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            468 => 
            array (
                'code' => 'FOCUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 469,
                'name' => 'Focus',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            469 => 
            array (
                'code' => 'FREESTAR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 470,
                'name' => 'Freestar',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            470 => 
            array (
                'code' => 'FREESTYLE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 471,
                'name' => 'Freestyle',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            471 => 
            array (
                'code' => 'FUSION',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 472,
                'name' => 'Fusion',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            472 => 
            array (
                'code' => 'GRANADA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 473,
                'name' => 'Granada',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            473 => 
            array (
                'code' => 'GT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 474,
                'name' => 'GT',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            474 => 
            array (
                'code' => 'LTD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 475,
                'name' => 'LTD',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            475 => 
            array (
                'code' => 'MUST',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 476,
                'name' => 'Mustang',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            476 => 
            array (
                'code' => 'PROBE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 477,
                'name' => 'Probe',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            477 => 
            array (
                'code' => 'RANGER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 478,
                'name' => 'Ranger',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            478 => 
            array (
                'code' => 'TAURUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 479,
                'name' => 'Taurus',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            479 => 
            array (
                'code' => 'TAURUSX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 480,
                'name' => 'Taurus X',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            480 => 
            array (
                'code' => 'TEMPO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 481,
                'name' => 'Tempo',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            481 => 
            array (
                'code' => 'TBIRD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 482,
                'name' => 'Thunderbird',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            482 => 
            array (
                'code' => 'TRANSCONN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 483,
                'name' => 'Transit Connect',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            483 => 
            array (
                'code' => 'WINDST',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 484,
                'name' => 'Windstar',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            484 => 
            array (
                'code' => 'FORDZX2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 485,
                'name' => 'ZX2 Escort',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            485 => 
            array (
                'code' => 'FOOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 486,
                'name' => 'Other Ford Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 22,
            ),
            486 => 
            array (
                'code' => 'FRESPRINT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 487,
                'name' => 'Sprinter',
                'updated_at' => NULL,
                'vehicle_make_id' => 23,
            ),
            487 => 
            array (
                'code' => 'GEOMETRO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 488,
                'name' => 'Metro',
                'updated_at' => NULL,
                'vehicle_make_id' => 24,
            ),
            488 => 
            array (
                'code' => 'GEOPRIZM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 489,
                'name' => 'Prizm',
                'updated_at' => NULL,
                'vehicle_make_id' => 24,
            ),
            489 => 
            array (
                'code' => 'SPECT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 490,
                'name' => 'Spectrum',
                'updated_at' => NULL,
                'vehicle_make_id' => 24,
            ),
            490 => 
            array (
                'code' => 'STORM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 491,
                'name' => 'Storm',
                'updated_at' => NULL,
                'vehicle_make_id' => 24,
            ),
            491 => 
            array (
                'code' => 'GEOTRACK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 492,
                'name' => 'Tracker',
                'updated_at' => NULL,
                'vehicle_make_id' => 24,
            ),
            492 => 
            array (
                'code' => 'GEOOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 493,
                'name' => 'Other Geo Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 24,
            ),
            493 => 
            array (
                'code' => 'ACADIA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 494,
                'name' => 'Acadia',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            494 => 
            array (
                'code' => 'CABALLERO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 495,
                'name' => 'Caballero',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            495 => 
            array (
                'code' => 'CANYON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 496,
                'name' => 'Canyon',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            496 => 
            array (
                'code' => 'ENVOY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 497,
                'name' => 'Envoy',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            497 => 
            array (
                'code' => 'ENVOYXL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 498,
                'name' => 'Envoy XL',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            498 => 
            array (
                'code' => 'ENVOYXUV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 499,
                'name' => 'Envoy XUV',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            499 => 
            array (
                'code' => 'JIM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 500,
                'name' => 'Jimmy',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
        ));
        \DB::table('vehicle_models')->insert(array (
            0 => 
            array (
                'code' => 'RALLYWAG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 501,
                'name' => 'Rally Wagon',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            1 => 
            array (
                'code' => 'GMCS15',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 502,
                'name' => 'S15 Jimmy',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            2 => 
            array (
                'code' => 'S15',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 503,
                'name' => 'S15 Pickup',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            3 => 
            array (
                'code' => 'SAFARIGMC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 504,
                'name' => 'Safari',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            4 => 
            array (
                'code' => 'GMCSAVANA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 505,
                'name' => 'Savana',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            5 => 
            array (
                'code' => '15SIPU4WD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 506,
                'name' => 'Sierra C/K1500',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            6 => 
            array (
                'code' => 'GMCC25PU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 507,
                'name' => 'Sierra C/K2500',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            7 => 
            array (
                'code' => 'GMC3500PU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 508,
                'name' => 'Sierra C/K3500',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            8 => 
            array (
                'code' => 'SONOMA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 509,
                'name' => 'Sonoma',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            9 => 
            array (
                'code' => 'SUB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 510,
                'name' => 'Suburban',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            10 => 
            array (
                'code' => 'GMCSYCLON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 511,
                'name' => 'Syclone',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            11 => 
            array (
                'code' => 'TERRAIN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 512,
                'name' => 'Terrain',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            12 => 
            array (
                'code' => 'TOPC4500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 513,
                'name' => 'TopKick C4500',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            13 => 
            array (
                'code' => 'TYPH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 514,
                'name' => 'Typhoon',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            14 => 
            array (
                'code' => 'GMCVANDUR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 515,
                'name' => 'Vandura',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            15 => 
            array (
                'code' => 'YUKON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 516,
                'name' => 'Yukon',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            16 => 
            array (
                'code' => 'YUKONXL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 517,
                'name' => 'Yukon XL',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            17 => 
            array (
                'code' => 'GMCOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 518,
                'name' => 'Other GMC Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 25,
            ),
            18 => 
            array (
                'code' => 'ACCORD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 519,
                'name' => 'Accord',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            19 => 
            array (
                'code' => 'CIVIC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 520,
                'name' => 'Civic',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            20 => 
            array (
                'code' => 'CRV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 521,
                'name' => 'CR-V',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            21 => 
            array (
                'code' => 'CRZ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 522,
                'name' => 'CR-Z',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            22 => 
            array (
                'code' => 'CRX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 523,
                'name' => 'CRX',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            23 => 
            array (
                'code' => 'CROSSTOUR_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 524,
            'name' => 'Crosstour and Accord Crosstour Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            24 => 
            array (
                'code' => 'CROSSTOUR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 525,
                'name' => 'Accord Crosstour',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            25 => 
            array (
                'code' => 'HONCROSS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 526,
                'name' => 'Crosstour',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            26 => 
            array (
                'code' => 'HONDELSOL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 527,
                'name' => 'Del Sol',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            27 => 
            array (
                'code' => 'ELEMENT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 528,
                'name' => 'Element',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            28 => 
            array (
                'code' => 'FIT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 529,
                'name' => 'Fit',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            29 => 
            array (
                'code' => 'INSIGHT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 530,
                'name' => 'Insight',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            30 => 
            array (
                'code' => 'ODYSSEY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 531,
                'name' => 'Odyssey',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            31 => 
            array (
                'code' => 'PASSPO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 532,
                'name' => 'Passport',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            32 => 
            array (
                'code' => 'PILOT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 533,
                'name' => 'Pilot',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            33 => 
            array (
                'code' => 'PRE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 534,
                'name' => 'Prelude',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            34 => 
            array (
                'code' => 'RIDGELINE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 535,
                'name' => 'Ridgeline',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            35 => 
            array (
                'code' => 'S2000',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 536,
                'name' => 'S2000',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            36 => 
            array (
                'code' => 'HONOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 537,
                'name' => 'Other Honda Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 26,
            ),
            37 => 
            array (
                'code' => 'HUMMER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 538,
                'name' => 'H1',
                'updated_at' => NULL,
                'vehicle_make_id' => 27,
            ),
            38 => 
            array (
                'code' => 'H2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 539,
                'name' => 'H2',
                'updated_at' => NULL,
                'vehicle_make_id' => 27,
            ),
            39 => 
            array (
                'code' => 'H3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 540,
                'name' => 'H3',
                'updated_at' => NULL,
                'vehicle_make_id' => 27,
            ),
            40 => 
            array (
                'code' => 'H3T',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 541,
                'name' => 'H3T',
                'updated_at' => NULL,
                'vehicle_make_id' => 27,
            ),
            41 => 
            array (
                'code' => 'AMGOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 542,
                'name' => 'Other Hummer Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 27,
            ),
            42 => 
            array (
                'code' => 'ACCENT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 543,
                'name' => 'Accent',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            43 => 
            array (
                'code' => 'AZERA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 544,
                'name' => 'Azera',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            44 => 
            array (
                'code' => 'ELANTR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 545,
                'name' => 'Elantra',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            45 => 
            array (
                'code' => 'HYUELANCPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 546,
                'name' => 'Elantra Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            46 => 
            array (
                'code' => 'ELANTOUR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 547,
                'name' => 'Elantra Touring',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            47 => 
            array (
                'code' => 'ENTOURAGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 548,
                'name' => 'Entourage',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            48 => 
            array (
                'code' => 'EQUUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 549,
                'name' => 'Equus',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            49 => 
            array (
                'code' => 'HYUEXCEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 550,
                'name' => 'Excel',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            50 => 
            array (
                'code' => 'GENESIS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 551,
                'name' => 'Genesis',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            51 => 
            array (
                'code' => 'GENESISCPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 552,
                'name' => 'Genesis Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            52 => 
            array (
                'code' => 'SANTAFE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 553,
                'name' => 'Santa Fe',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            53 => 
            array (
                'code' => 'SCOUPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 554,
                'name' => 'Scoupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            54 => 
            array (
                'code' => 'SONATA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 555,
                'name' => 'Sonata',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            55 => 
            array (
                'code' => 'TIBURO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 556,
                'name' => 'Tiburon',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            56 => 
            array (
                'code' => 'TUCSON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 557,
                'name' => 'Tucson',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            57 => 
            array (
                'code' => 'VELOSTER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 558,
                'name' => 'Veloster',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            58 => 
            array (
                'code' => 'VERACRUZ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 559,
                'name' => 'Veracruz',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            59 => 
            array (
                'code' => 'XG300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 560,
                'name' => 'XG300',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            60 => 
            array (
                'code' => 'XG350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 561,
                'name' => 'XG350',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            61 => 
            array (
                'code' => 'HYUOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 562,
                'name' => 'Other Hyundai Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 28,
            ),
            62 => 
            array (
                'code' => 'EX_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 563,
            'name' => 'EX Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            63 => 
            array (
                'code' => 'EX35',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 564,
                'name' => 'EX35',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            64 => 
            array (
                'code' => 'EX37',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 565,
                'name' => 'EX37',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            65 => 
            array (
                'code' => 'FX_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 566,
            'name' => 'FX Models (4)',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            66 => 
            array (
                'code' => 'FX35',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 567,
                'name' => 'FX35',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            67 => 
            array (
                'code' => 'FX37',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 568,
                'name' => 'FX37',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            68 => 
            array (
                'code' => 'FX45',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 569,
                'name' => 'FX45',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            69 => 
            array (
                'code' => 'FX50',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 570,
                'name' => 'FX50',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            70 => 
            array (
                'code' => 'G_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 571,
            'name' => 'G Models (4)',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            71 => 
            array (
                'code' => 'G20',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 572,
                'name' => 'G20',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            72 => 
            array (
                'code' => 'G25',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 573,
                'name' => 'G25',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            73 => 
            array (
                'code' => 'G35',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 574,
                'name' => 'G35',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            74 => 
            array (
                'code' => 'G37',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 575,
                'name' => 'G37',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            75 => 
            array (
                'code' => 'I_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 576,
            'name' => 'I Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            76 => 
            array (
                'code' => 'I30',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 577,
                'name' => 'I30',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            77 => 
            array (
                'code' => 'I35',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 578,
                'name' => 'I35',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            78 => 
            array (
                'code' => 'J_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 579,
            'name' => 'J Models (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            79 => 
            array (
                'code' => 'J30',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 580,
                'name' => 'J30',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            80 => 
            array (
                'code' => 'JX_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 581,
            'name' => 'JX Models (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            81 => 
            array (
                'code' => 'JX35',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 582,
                'name' => 'JX35',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            82 => 
            array (
                'code' => 'M_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 583,
            'name' => 'M Models (6)',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            83 => 
            array (
                'code' => 'M30',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 584,
                'name' => 'M30',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            84 => 
            array (
                'code' => 'M35',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 585,
                'name' => 'M35',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            85 => 
            array (
                'code' => 'M35HYBRID',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 586,
                'name' => 'M35h',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            86 => 
            array (
                'code' => 'M37',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 587,
                'name' => 'M37',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            87 => 
            array (
                'code' => 'M45',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 588,
                'name' => 'M45',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            88 => 
            array (
                'code' => 'M56',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 589,
                'name' => 'M56',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            89 => 
            array (
                'code' => 'Q_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 590,
            'name' => 'Q Models (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            90 => 
            array (
                'code' => 'Q45',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 591,
                'name' => 'Q45',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            91 => 
            array (
                'code' => 'QX_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 592,
            'name' => 'QX Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            92 => 
            array (
                'code' => 'QX4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 593,
                'name' => 'QX4',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            93 => 
            array (
                'code' => 'QX56',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 594,
                'name' => 'QX56',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            94 => 
            array (
                'code' => 'INFOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 595,
                'name' => 'Other Infiniti Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 29,
            ),
            95 => 
            array (
                'code' => 'AMIGO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 596,
                'name' => 'Amigo',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            96 => 
            array (
                'code' => 'ASCENDER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 597,
                'name' => 'Ascender',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            97 => 
            array (
                'code' => 'AXIOM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 598,
                'name' => 'Axiom',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            98 => 
            array (
                'code' => 'HOMBRE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 599,
                'name' => 'Hombre',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            99 => 
            array (
                'code' => 'I280',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 600,
                'name' => 'i-280',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            100 => 
            array (
                'code' => 'I290',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 601,
                'name' => 'i-290',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            101 => 
            array (
                'code' => 'I350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 602,
                'name' => 'i-350',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            102 => 
            array (
                'code' => 'I370',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 603,
                'name' => 'i-370',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            103 => 
            array (
                'code' => 'ISUMARK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 604,
                'name' => 'I-Mark',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            104 => 
            array (
                'code' => 'ISUIMP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 605,
                'name' => 'Impulse',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            105 => 
            array (
                'code' => 'OASIS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 606,
                'name' => 'Oasis',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            106 => 
            array (
                'code' => 'ISUPU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 607,
                'name' => 'Pickup',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            107 => 
            array (
                'code' => 'RODEO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 608,
                'name' => 'Rodeo',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            108 => 
            array (
                'code' => 'STYLUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 609,
                'name' => 'Stylus',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            109 => 
            array (
                'code' => 'TROOP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 610,
                'name' => 'Trooper',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            110 => 
            array (
                'code' => 'TRP2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 611,
                'name' => 'Trooper II',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            111 => 
            array (
                'code' => 'VEHICROSS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 612,
                'name' => 'VehiCROSS',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            112 => 
            array (
                'code' => 'ISUOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 613,
                'name' => 'Other Isuzu Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 30,
            ),
            113 => 
            array (
                'code' => 'STYPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 614,
                'name' => 'S-Type',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            114 => 
            array (
                'code' => 'XTYPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 615,
                'name' => 'X-Type',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            115 => 
            array (
                'code' => 'XF',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 616,
                'name' => 'XF',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            116 => 
            array (
                'code' => 'XJ_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 617,
            'name' => 'XJ Series (10)',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            117 => 
            array (
                'code' => 'JAGXJ12',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 618,
                'name' => 'XJ12',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            118 => 
            array (
                'code' => 'JAGXJ6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 619,
                'name' => 'XJ6',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            119 => 
            array (
                'code' => 'JAGXJR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 620,
                'name' => 'XJR',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            120 => 
            array (
                'code' => 'JAGXJRS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 621,
                'name' => 'XJR-S',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            121 => 
            array (
                'code' => 'JAGXJS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 622,
                'name' => 'XJS',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            122 => 
            array (
                'code' => 'VANDEN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 623,
                'name' => 'XJ Vanden Plas',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            123 => 
            array (
                'code' => 'XJ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 624,
                'name' => 'XJ',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            124 => 
            array (
                'code' => 'XJ8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 625,
                'name' => 'XJ8',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            125 => 
            array (
                'code' => 'XJ8L',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 626,
                'name' => 'XJ8 L',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            126 => 
            array (
                'code' => 'XJSPORT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 627,
                'name' => 'XJ Sport',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            127 => 
            array (
                'code' => 'XK_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 628,
            'name' => 'XK Series (3)',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            128 => 
            array (
                'code' => 'JAGXK8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 629,
                'name' => 'XK8',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            129 => 
            array (
                'code' => 'XK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 630,
                'name' => 'XK',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            130 => 
            array (
                'code' => 'XKR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 631,
                'name' => 'XKR',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            131 => 
            array (
                'code' => 'JAGOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 632,
                'name' => 'Other Jaguar Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 31,
            ),
            132 => 
            array (
                'code' => 'CHER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 633,
                'name' => 'Cherokee',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            133 => 
            array (
                'code' => 'JEEPCJ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 634,
                'name' => 'CJ',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            134 => 
            array (
                'code' => 'COMANC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 635,
                'name' => 'Comanche',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            135 => 
            array (
                'code' => 'COMMANDER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 636,
                'name' => 'Commander',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            136 => 
            array (
                'code' => 'COMPASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 637,
                'name' => 'Compass',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            137 => 
            array (
                'code' => 'JEEPGRAND',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 638,
                'name' => 'Grand Cherokee',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            138 => 
            array (
                'code' => 'GRWAG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 639,
                'name' => 'Grand Wagoneer',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            139 => 
            array (
                'code' => 'LIBERTY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 640,
                'name' => 'Liberty',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            140 => 
            array (
                'code' => 'PATRIOT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 641,
                'name' => 'Patriot',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            141 => 
            array (
                'code' => 'JEEPPU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 642,
                'name' => 'Pickup',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            142 => 
            array (
                'code' => 'SCRAMBLE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 643,
                'name' => 'Scrambler',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            143 => 
            array (
                'code' => 'WAGONE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 644,
                'name' => 'Wagoneer',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            144 => 
            array (
                'code' => 'WRANGLER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 645,
                'name' => 'Wrangler',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            145 => 
            array (
                'code' => 'JEOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 646,
                'name' => 'Other Jeep Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 32,
            ),
            146 => 
            array (
                'code' => 'AMANTI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 647,
                'name' => 'Amanti',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            147 => 
            array (
                'code' => 'BORREGO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 648,
                'name' => 'Borrego',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            148 => 
            array (
                'code' => 'FORTE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 649,
                'name' => 'Forte',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            149 => 
            array (
                'code' => 'FORTEKOUP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 650,
                'name' => 'Forte Koup',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            150 => 
            array (
                'code' => 'OPTIMA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 651,
                'name' => 'Optima',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            151 => 
            array (
                'code' => 'RIO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 652,
                'name' => 'Rio',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            152 => 
            array (
                'code' => 'RIO5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 653,
                'name' => 'Rio5',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            153 => 
            array (
                'code' => 'RONDO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 654,
                'name' => 'Rondo',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            154 => 
            array (
                'code' => 'SEDONA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 655,
                'name' => 'Sedona',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            155 => 
            array (
                'code' => 'SEPHIA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 656,
                'name' => 'Sephia',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            156 => 
            array (
                'code' => 'SORENTO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 657,
                'name' => 'Sorento',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            157 => 
            array (
                'code' => 'SOUL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 658,
                'name' => 'Soul',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            158 => 
            array (
                'code' => 'SPECTRA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 659,
                'name' => 'Spectra',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            159 => 
            array (
                'code' => 'SPECTRA5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 660,
                'name' => 'Spectra5',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            160 => 
            array (
                'code' => 'SPORTA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 661,
                'name' => 'Sportage',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            161 => 
            array (
                'code' => 'KIAOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 662,
                'name' => 'Other Kia Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 33,
            ),
            162 => 
            array (
                'code' => 'AVENT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 663,
                'name' => 'Aventador',
                'updated_at' => NULL,
                'vehicle_make_id' => 34,
            ),
            163 => 
            array (
                'code' => 'COUNT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 664,
                'name' => 'Countach',
                'updated_at' => NULL,
                'vehicle_make_id' => 34,
            ),
            164 => 
            array (
                'code' => 'DIABLO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 665,
                'name' => 'Diablo',
                'updated_at' => NULL,
                'vehicle_make_id' => 34,
            ),
            165 => 
            array (
                'code' => 'GALLARDO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 666,
                'name' => 'Gallardo',
                'updated_at' => NULL,
                'vehicle_make_id' => 34,
            ),
            166 => 
            array (
                'code' => 'JALPA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 667,
                'name' => 'Jalpa',
                'updated_at' => NULL,
                'vehicle_make_id' => 34,
            ),
            167 => 
            array (
                'code' => 'LM002',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 668,
                'name' => 'LM002',
                'updated_at' => NULL,
                'vehicle_make_id' => 34,
            ),
            168 => 
            array (
                'code' => 'MURCIELAGO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 669,
                'name' => 'Murcielago',
                'updated_at' => NULL,
                'vehicle_make_id' => 34,
            ),
            169 => 
            array (
                'code' => 'UNAVAILLAM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 670,
                'name' => 'Other Lamborghini Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 34,
            ),
            170 => 
            array (
                'code' => 'BETA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 671,
                'name' => 'Beta',
                'updated_at' => NULL,
                'vehicle_make_id' => 35,
            ),
            171 => 
            array (
                'code' => 'ZAGATO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 672,
                'name' => 'Zagato',
                'updated_at' => NULL,
                'vehicle_make_id' => 35,
            ),
            172 => 
            array (
                'code' => 'UNAVAILLAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 673,
                'name' => 'Other Lancia Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 35,
            ),
            173 => 
            array (
                'code' => 'DEFEND',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 674,
                'name' => 'Defender',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            174 => 
            array (
                'code' => 'DISCOV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 675,
                'name' => 'Discovery',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            175 => 
            array (
                'code' => 'FRELNDR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 676,
                'name' => 'Freelander',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            176 => 
            array (
                'code' => 'LR2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 677,
                'name' => 'LR2',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            177 => 
            array (
                'code' => 'LR3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 678,
                'name' => 'LR3',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            178 => 
            array (
                'code' => 'LR4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 679,
                'name' => 'LR4',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            179 => 
            array (
                'code' => 'RANGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 680,
                'name' => 'Range Rover',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            180 => 
            array (
                'code' => 'EVOQUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 681,
                'name' => 'Range Rover Evoque',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            181 => 
            array (
                'code' => 'RANGESPORT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 682,
                'name' => 'Range Rover Sport',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            182 => 
            array (
                'code' => 'ROVOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 683,
                'name' => 'Other Land Rover Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 36,
            ),
            183 => 
            array (
                'code' => 'CT_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 684,
            'name' => 'CT Models (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            184 => 
            array (
                'code' => 'CT200H',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 685,
                'name' => 'CT 200h',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            185 => 
            array (
                'code' => 'ES_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 686,
            'name' => 'ES Models (5)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            186 => 
            array (
                'code' => 'ES250',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 687,
                'name' => 'ES 250',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            187 => 
            array (
                'code' => 'ES300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 688,
                'name' => 'ES 300',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            188 => 
            array (
                'code' => 'ES300H',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 689,
                'name' => 'ES 300h',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            189 => 
            array (
                'code' => 'ES330',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 690,
                'name' => 'ES 330',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            190 => 
            array (
                'code' => 'ES350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 691,
                'name' => 'ES 350',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            191 => 
            array (
                'code' => 'GS_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 692,
            'name' => 'GS Models (6)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            192 => 
            array (
                'code' => 'GS300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 693,
                'name' => 'GS 300',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            193 => 
            array (
                'code' => 'GS350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 694,
                'name' => 'GS 350',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            194 => 
            array (
                'code' => 'GS400',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 695,
                'name' => 'GS 400',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            195 => 
            array (
                'code' => 'GS430',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 696,
                'name' => 'GS 430',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            196 => 
            array (
                'code' => 'GS450H',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 697,
                'name' => 'GS 450h',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            197 => 
            array (
                'code' => 'GS460',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 698,
                'name' => 'GS 460',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            198 => 
            array (
                'code' => 'GX_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 699,
            'name' => 'GX Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            199 => 
            array (
                'code' => 'GX460',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 700,
                'name' => 'GX 460',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            200 => 
            array (
                'code' => 'GX470',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 701,
                'name' => 'GX 470',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            201 => 
            array (
                'code' => 'HS_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 702,
            'name' => 'HS Models (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            202 => 
            array (
                'code' => 'HS250H',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 703,
                'name' => 'HS 250h',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            203 => 
            array (
                'code' => 'IS_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 704,
            'name' => 'IS Models (6)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            204 => 
            array (
                'code' => 'IS250',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 705,
                'name' => 'IS 250',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            205 => 
            array (
                'code' => 'IS250C',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 706,
                'name' => 'IS 250C',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            206 => 
            array (
                'code' => 'IS300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 707,
                'name' => 'IS 300',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            207 => 
            array (
                'code' => 'IS350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 708,
                'name' => 'IS 350',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            208 => 
            array (
                'code' => 'IS350C',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 709,
                'name' => 'IS 350C',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            209 => 
            array (
                'code' => 'ISF',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 710,
                'name' => 'IS F',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            210 => 
            array (
                'code' => 'LEXLFA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 711,
                'name' => 'LFA',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            211 => 
            array (
                'code' => 'LS_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 712,
            'name' => 'LS Models (4)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            212 => 
            array (
                'code' => 'LS400',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 713,
                'name' => 'LS 400',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            213 => 
            array (
                'code' => 'LS430',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 714,
                'name' => 'LS 430',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            214 => 
            array (
                'code' => 'LS460',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 715,
                'name' => 'LS 460',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            215 => 
            array (
                'code' => 'LS600H',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 716,
                'name' => 'LS 600h',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            216 => 
            array (
                'code' => 'LX_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 717,
            'name' => 'LX Models (3)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            217 => 
            array (
                'code' => 'LX450',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 718,
                'name' => 'LX 450',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            218 => 
            array (
                'code' => 'LX470',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 719,
                'name' => 'LX 470',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            219 => 
            array (
                'code' => 'LX570',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 720,
                'name' => 'LX 570',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            220 => 
            array (
                'code' => 'RX_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 721,
            'name' => 'RX Models (5)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            221 => 
            array (
                'code' => 'RX300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 722,
                'name' => 'RX 300',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            222 => 
            array (
                'code' => 'RX330',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 723,
                'name' => 'RX 330',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            223 => 
            array (
                'code' => 'RX350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 724,
                'name' => 'RX 350',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            224 => 
            array (
                'code' => 'RX400H',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 725,
                'name' => 'RX 400h',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            225 => 
            array (
                'code' => 'RX450H',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 726,
                'name' => 'RX 450h',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            226 => 
            array (
                'code' => 'SC_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 727,
            'name' => 'SC Models (3)',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            227 => 
            array (
                'code' => 'SC300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 728,
                'name' => 'SC 300',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            228 => 
            array (
                'code' => 'SC400',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 729,
                'name' => 'SC 400',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            229 => 
            array (
                'code' => 'SC430',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 730,
                'name' => 'SC 430',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            230 => 
            array (
                'code' => 'LEXOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 731,
                'name' => 'Other Lexus Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 37,
            ),
            231 => 
            array (
                'code' => 'AVIATOR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 732,
                'name' => 'Aviator',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            232 => 
            array (
                'code' => 'BLKWOOD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 733,
                'name' => 'Blackwood',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            233 => 
            array (
                'code' => 'CONT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 734,
                'name' => 'Continental',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            234 => 
            array (
                'code' => 'LSLINCOLN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 735,
                'name' => 'LS',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            235 => 
            array (
                'code' => 'MARKLT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 736,
                'name' => 'Mark LT',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            236 => 
            array (
                'code' => 'MARK6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 737,
                'name' => 'Mark VI',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            237 => 
            array (
                'code' => 'MARK7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 738,
                'name' => 'Mark VII',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            238 => 
            array (
                'code' => 'MARK8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 739,
                'name' => 'Mark VIII',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            239 => 
            array (
                'code' => 'MKS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 740,
                'name' => 'MKS',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            240 => 
            array (
                'code' => 'MKT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 741,
                'name' => 'MKT',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            241 => 
            array (
                'code' => 'MKX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 742,
                'name' => 'MKX',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            242 => 
            array (
                'code' => 'MKZ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 743,
                'name' => 'MKZ',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            243 => 
            array (
                'code' => 'NAVIGA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 744,
                'name' => 'Navigator',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            244 => 
            array (
                'code' => 'NAVIGAL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 745,
                'name' => 'Navigator L',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            245 => 
            array (
                'code' => 'LINCTC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 746,
                'name' => 'Town Car',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            246 => 
            array (
                'code' => 'ZEPHYR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 747,
                'name' => 'Zephyr',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            247 => 
            array (
                'code' => 'LINOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 748,
                'name' => 'Other Lincoln Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 38,
            ),
            248 => 
            array (
                'code' => 'ELAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 749,
                'name' => 'Elan',
                'updated_at' => NULL,
                'vehicle_make_id' => 39,
            ),
            249 => 
            array (
                'code' => 'LOTELISE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 750,
                'name' => 'Elise',
                'updated_at' => NULL,
                'vehicle_make_id' => 39,
            ),
            250 => 
            array (
                'code' => 'ESPRIT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 751,
                'name' => 'Esprit',
                'updated_at' => NULL,
                'vehicle_make_id' => 39,
            ),
            251 => 
            array (
                'code' => 'EVORA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 752,
                'name' => 'Evora',
                'updated_at' => NULL,
                'vehicle_make_id' => 39,
            ),
            252 => 
            array (
                'code' => 'EXIGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 753,
                'name' => 'Exige',
                'updated_at' => NULL,
                'vehicle_make_id' => 39,
            ),
            253 => 
            array (
                'code' => 'UNAVAILLOT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 754,
                'name' => 'Other Lotus Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 39,
            ),
            254 => 
            array (
                'code' => '430',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 755,
                'name' => '430',
                'updated_at' => NULL,
                'vehicle_make_id' => 40,
            ),
            255 => 
            array (
                'code' => 'BITRBO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 756,
                'name' => 'Biturbo',
                'updated_at' => NULL,
                'vehicle_make_id' => 40,
            ),
            256 => 
            array (
                'code' => 'COUPEMAS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 757,
                'name' => 'Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 40,
            ),
            257 => 
            array (
                'code' => 'GRANSPORT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 758,
                'name' => 'GranSport',
                'updated_at' => NULL,
                'vehicle_make_id' => 40,
            ),
            258 => 
            array (
                'code' => 'GRANTURISM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 759,
                'name' => 'GranTurismo',
                'updated_at' => NULL,
                'vehicle_make_id' => 40,
            ),
            259 => 
            array (
                'code' => 'QP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 760,
                'name' => 'Quattroporte',
                'updated_at' => NULL,
                'vehicle_make_id' => 40,
            ),
            260 => 
            array (
                'code' => 'SPYDER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 761,
                'name' => 'Spyder',
                'updated_at' => NULL,
                'vehicle_make_id' => 40,
            ),
            261 => 
            array (
                'code' => 'UNAVAILMAS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 762,
                'name' => 'Other Maserati Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 40,
            ),
            262 => 
            array (
                'code' => '57MAYBACH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 763,
                'name' => '57',
                'updated_at' => NULL,
                'vehicle_make_id' => 41,
            ),
            263 => 
            array (
                'code' => '62MAYBACH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 764,
                'name' => '62',
                'updated_at' => NULL,
                'vehicle_make_id' => 41,
            ),
            264 => 
            array (
                'code' => 'UNAVAILMAY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 765,
                'name' => 'Other Maybach Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 41,
            ),
            265 => 
            array (
                'code' => 'MAZDA323',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 766,
                'name' => '323',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            266 => 
            array (
                'code' => 'MAZDA626',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 767,
                'name' => '626',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            267 => 
            array (
                'code' => '929',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 768,
                'name' => '929',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            268 => 
            array (
                'code' => 'B-SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 769,
                'name' => 'B-Series Pickup',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            269 => 
            array (
                'code' => 'CX-5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 770,
                'name' => 'CX-5',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            270 => 
            array (
                'code' => 'CX-7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 771,
                'name' => 'CX-7',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            271 => 
            array (
                'code' => 'CX-9',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 772,
                'name' => 'CX-9',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            272 => 
            array (
                'code' => 'GLC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 773,
                'name' => 'GLC',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            273 => 
            array (
                'code' => 'MAZDA2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 774,
                'name' => 'MAZDA2',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            274 => 
            array (
                'code' => 'MAZDA3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 775,
                'name' => 'MAZDA3',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            275 => 
            array (
                'code' => 'MAZDA5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 776,
                'name' => 'MAZDA5',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            276 => 
            array (
                'code' => 'MAZDA6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 777,
                'name' => 'MAZDA6',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            277 => 
            array (
                'code' => 'MAZDASPD3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 778,
                'name' => 'MAZDASPEED3',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            278 => 
            array (
                'code' => 'MAZDASPD6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 779,
                'name' => 'MAZDASPEED6',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            279 => 
            array (
                'code' => 'MIATA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 780,
                'name' => 'Miata MX5',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            280 => 
            array (
                'code' => 'MILL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 781,
                'name' => 'Millenia',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            281 => 
            array (
                'code' => 'MPV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 782,
                'name' => 'MPV',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            282 => 
            array (
                'code' => 'MX3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 783,
                'name' => 'MX3',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            283 => 
            array (
                'code' => 'MX6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 784,
                'name' => 'MX6',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            284 => 
            array (
                'code' => 'NAVAJO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 785,
                'name' => 'Navajo',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            285 => 
            array (
                'code' => 'PROTE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 786,
                'name' => 'Protege',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            286 => 
            array (
                'code' => 'PROTE5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 787,
                'name' => 'Protege5',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            287 => 
            array (
                'code' => 'RX7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 788,
                'name' => 'RX-7',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            288 => 
            array (
                'code' => 'RX8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 789,
                'name' => 'RX-8',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            289 => 
            array (
                'code' => 'TRIBUTE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 790,
                'name' => 'Tribute',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            290 => 
            array (
                'code' => 'MAZOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 791,
                'name' => 'Other Mazda Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 42,
            ),
            291 => 
            array (
                'code' => 'MP4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 792,
                'name' => 'MP4-12C',
                'updated_at' => NULL,
                'vehicle_make_id' => 43,
            ),
            292 => 
            array (
                'code' => '190_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 793,
            'name' => '190 Class (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            293 => 
            array (
                'code' => '190D',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 794,
                'name' => '190D',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            294 => 
            array (
                'code' => '190E',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 795,
                'name' => '190E',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            295 => 
            array (
                'code' => '240_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 796,
            'name' => '240 Class (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            296 => 
            array (
                'code' => '240D',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 797,
                'name' => '240D',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            297 => 
            array (
                'code' => '300_CLASS_E_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 798,
            'name' => '300 Class / E Class (6)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            298 => 
            array (
                'code' => '300CD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 799,
                'name' => '300CD',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            299 => 
            array (
                'code' => '300CE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 800,
                'name' => '300CE',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            300 => 
            array (
                'code' => '300D',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 801,
                'name' => '300D',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            301 => 
            array (
                'code' => '300E',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 802,
                'name' => '300E',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            302 => 
            array (
                'code' => '300TD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 803,
                'name' => '300TD',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            303 => 
            array (
                'code' => '300TE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 804,
                'name' => '300TE',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            304 => 
            array (
                'code' => 'C_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 805,
            'name' => 'C Class (13)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            305 => 
            array (
                'code' => 'C220',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 806,
                'name' => 'C220',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            306 => 
            array (
                'code' => 'C230',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 807,
                'name' => 'C230',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            307 => 
            array (
                'code' => 'C240',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 808,
                'name' => 'C240',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            308 => 
            array (
                'code' => 'C250',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 809,
                'name' => 'C250',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            309 => 
            array (
                'code' => 'C280',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 810,
                'name' => 'C280',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            310 => 
            array (
                'code' => 'C300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 811,
                'name' => 'C300',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            311 => 
            array (
                'code' => 'C320',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 812,
                'name' => 'C320',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            312 => 
            array (
                'code' => 'C32AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 813,
                'name' => 'C32 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            313 => 
            array (
                'code' => 'C350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 814,
                'name' => 'C350',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            314 => 
            array (
                'code' => 'C36AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 815,
                'name' => 'C36 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            315 => 
            array (
                'code' => 'C43AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 816,
                'name' => 'C43 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            316 => 
            array (
                'code' => 'C55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 817,
                'name' => 'C55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            317 => 
            array (
                'code' => 'C63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 818,
                'name' => 'C63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            318 => 
            array (
                'code' => 'CL_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 819,
            'name' => 'CL Class (6)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            319 => 
            array (
                'code' => 'CL500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 820,
                'name' => 'CL500',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            320 => 
            array (
                'code' => 'CL550',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 821,
                'name' => 'CL550',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            321 => 
            array (
                'code' => 'CL55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 822,
                'name' => 'CL55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            322 => 
            array (
                'code' => 'CL600',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 823,
                'name' => 'CL600',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            323 => 
            array (
                'code' => 'CL63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 824,
                'name' => 'CL63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            324 => 
            array (
                'code' => 'CL65AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 825,
                'name' => 'CL65 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            325 => 
            array (
                'code' => 'CLK_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 826,
            'name' => 'CLK Class (7)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            326 => 
            array (
                'code' => 'CLK320',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 827,
                'name' => 'CLK320',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            327 => 
            array (
                'code' => 'CLK350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 828,
                'name' => 'CLK350',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            328 => 
            array (
                'code' => 'CLK430',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 829,
                'name' => 'CLK430',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            329 => 
            array (
                'code' => 'CLK500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 830,
                'name' => 'CLK500',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            330 => 
            array (
                'code' => 'CLK550',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 831,
                'name' => 'CLK550',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            331 => 
            array (
                'code' => 'CLK55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 832,
                'name' => 'CLK55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            332 => 
            array (
                'code' => 'CLK63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 833,
                'name' => 'CLK63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            333 => 
            array (
                'code' => 'CLS_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 834,
            'name' => 'CLS Class (4)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            334 => 
            array (
                'code' => 'CLS500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 835,
                'name' => 'CLS500',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            335 => 
            array (
                'code' => 'CLS550',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 836,
                'name' => 'CLS550',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            336 => 
            array (
                'code' => 'CLS55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 837,
                'name' => 'CLS55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            337 => 
            array (
                'code' => 'CLS63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 838,
                'name' => 'CLS63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            338 => 
            array (
                'code' => 'E_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 839,
            'name' => 'E Class (18)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            339 => 
            array (
                'code' => '260E',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 840,
                'name' => '260E',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            340 => 
            array (
                'code' => '280CE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 841,
                'name' => '280CE',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            341 => 
            array (
                'code' => '280E',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 842,
                'name' => '280E',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            342 => 
            array (
                'code' => '400E',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 843,
                'name' => '400E',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            343 => 
            array (
                'code' => '500E',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 844,
                'name' => '500E',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            344 => 
            array (
                'code' => 'E300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 845,
                'name' => 'E300',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            345 => 
            array (
                'code' => 'E320',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 846,
                'name' => 'E320',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            346 => 
            array (
                'code' => 'E320BLUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 847,
                'name' => 'E320 Bluetec',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            347 => 
            array (
                'code' => 'E320CDI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 848,
                'name' => 'E320 CDI',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            348 => 
            array (
                'code' => 'E350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 849,
                'name' => 'E350',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            349 => 
            array (
                'code' => 'E350BLUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 850,
                'name' => 'E350 Bluetec',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            350 => 
            array (
                'code' => 'E400',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 851,
                'name' => 'E400 Hybrid',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            351 => 
            array (
                'code' => 'E420',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 852,
                'name' => 'E420',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            352 => 
            array (
                'code' => 'E430',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 853,
                'name' => 'E430',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            353 => 
            array (
                'code' => 'E500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 854,
                'name' => 'E500',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            354 => 
            array (
                'code' => 'E550',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 855,
                'name' => 'E550',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            355 => 
            array (
                'code' => 'E55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 856,
                'name' => 'E55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            356 => 
            array (
                'code' => 'E63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 857,
                'name' => 'E63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            357 => 
            array (
                'code' => 'G_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 858,
            'name' => 'G Class (4)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            358 => 
            array (
                'code' => 'G500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 859,
                'name' => 'G500',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            359 => 
            array (
                'code' => 'G550',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 860,
                'name' => 'G550',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            360 => 
            array (
                'code' => 'G55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 861,
                'name' => 'G55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            361 => 
            array (
                'code' => 'G63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 862,
                'name' => 'G63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            362 => 
            array (
                'code' => 'GL_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 863,
            'name' => 'GL Class (5)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            363 => 
            array (
                'code' => 'GL320BLUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 864,
                'name' => 'GL320 Bluetec',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            364 => 
            array (
                'code' => 'GL320CDI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 865,
                'name' => 'GL320 CDI',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            365 => 
            array (
                'code' => 'GL350BLUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 866,
                'name' => 'GL350 Bluetec',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            366 => 
            array (
                'code' => 'GL450',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 867,
                'name' => 'GL450',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            367 => 
            array (
                'code' => 'GL550',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 868,
                'name' => 'GL550',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            368 => 
            array (
                'code' => 'GLK_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 869,
            'name' => 'GLK Class (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            369 => 
            array (
                'code' => 'GLK350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 870,
                'name' => 'GLK350',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            370 => 
            array (
                'code' => 'M_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 871,
            'name' => 'M Class (11)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            371 => 
            array (
                'code' => 'ML320',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 872,
                'name' => 'ML320',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            372 => 
            array (
                'code' => 'ML320BLUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 873,
                'name' => 'ML320 Bluetec',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            373 => 
            array (
                'code' => 'ML320CDI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 874,
                'name' => 'ML320 CDI',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            374 => 
            array (
                'code' => 'ML350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 875,
                'name' => 'ML350',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            375 => 
            array (
                'code' => 'ML350BLUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 876,
                'name' => 'ML350 Bluetec',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            376 => 
            array (
                'code' => 'ML430',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 877,
                'name' => 'ML430',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            377 => 
            array (
                'code' => 'ML450HY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 878,
                'name' => 'ML450 Hybrid',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            378 => 
            array (
                'code' => 'ML500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 879,
                'name' => 'ML500',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            379 => 
            array (
                'code' => 'ML550',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 880,
                'name' => 'ML550',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            380 => 
            array (
                'code' => 'ML55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 881,
                'name' => 'ML55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            381 => 
            array (
                'code' => 'ML63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 882,
                'name' => 'ML63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            382 => 
            array (
                'code' => 'R_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 883,
            'name' => 'R Class (6)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            383 => 
            array (
                'code' => 'R320BLUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 884,
                'name' => 'R320 Bluetec',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            384 => 
            array (
                'code' => 'R320CDI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 885,
                'name' => 'R320 CDI',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            385 => 
            array (
                'code' => 'R350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 886,
                'name' => 'R350',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            386 => 
            array (
                'code' => 'R350BLUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 887,
                'name' => 'R350 Bluetec',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            387 => 
            array (
                'code' => 'R500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 888,
                'name' => 'R500',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            388 => 
            array (
                'code' => 'R63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 889,
                'name' => 'R63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            389 => 
            array (
                'code' => 'S_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 890,
            'name' => 'S Class (30)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            390 => 
            array (
                'code' => '300SD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 891,
                'name' => '300SD',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            391 => 
            array (
                'code' => '300SDL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 892,
                'name' => '300SDL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            392 => 
            array (
                'code' => '300SE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 893,
                'name' => '300SE',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            393 => 
            array (
                'code' => '300SEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 894,
                'name' => '300SEL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            394 => 
            array (
                'code' => '350SD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 895,
                'name' => '350SD',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            395 => 
            array (
                'code' => '350SDL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 896,
                'name' => '350SDL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            396 => 
            array (
                'code' => '380SE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 897,
                'name' => '380SE',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            397 => 
            array (
                'code' => '380SEC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 898,
                'name' => '380SEC',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            398 => 
            array (
                'code' => '380SEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 899,
                'name' => '380SEL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            399 => 
            array (
                'code' => '400SE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 900,
                'name' => '400SE',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            400 => 
            array (
                'code' => '400SEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 901,
                'name' => '400SEL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            401 => 
            array (
                'code' => '420SEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 902,
                'name' => '420SEL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            402 => 
            array (
                'code' => '500SEC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 903,
                'name' => '500SEC',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            403 => 
            array (
                'code' => '500SEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 904,
                'name' => '500SEL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            404 => 
            array (
                'code' => '560SEC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 905,
                'name' => '560SEC',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            405 => 
            array (
                'code' => '560SEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 906,
                'name' => '560SEL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            406 => 
            array (
                'code' => '600SEC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 907,
                'name' => '600SEC',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            407 => 
            array (
                'code' => '600SEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 908,
                'name' => '600SEL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            408 => 
            array (
                'code' => 'S320',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 909,
                'name' => 'S320',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            409 => 
            array (
                'code' => 'S350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 910,
                'name' => 'S350',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            410 => 
            array (
                'code' => 'S350BLUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 911,
                'name' => 'S350 Bluetec',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            411 => 
            array (
                'code' => 'S400HY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 912,
                'name' => 'S400 Hybrid',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            412 => 
            array (
                'code' => 'S420',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 913,
                'name' => 'S420',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            413 => 
            array (
                'code' => 'S430',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 914,
                'name' => 'S430',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            414 => 
            array (
                'code' => 'S500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 915,
                'name' => 'S500',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            415 => 
            array (
                'code' => 'S550',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 916,
                'name' => 'S550',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            416 => 
            array (
                'code' => 'S55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 917,
                'name' => 'S55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            417 => 
            array (
                'code' => 'S600',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 918,
                'name' => 'S600',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            418 => 
            array (
                'code' => 'S63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 919,
                'name' => 'S63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            419 => 
            array (
                'code' => 'S65AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 920,
                'name' => 'S65 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            420 => 
            array (
                'code' => 'SL_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 921,
            'name' => 'SL Class (13)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            421 => 
            array (
                'code' => '300SL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 922,
                'name' => '300SL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            422 => 
            array (
                'code' => '380SL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 923,
                'name' => '380SL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            423 => 
            array (
                'code' => '380SLC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 924,
                'name' => '380SLC',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            424 => 
            array (
                'code' => '500SL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 925,
                'name' => '500SL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            425 => 
            array (
                'code' => '560SL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 926,
                'name' => '560SL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            426 => 
            array (
                'code' => '600SL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 927,
                'name' => '600SL',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            427 => 
            array (
                'code' => 'SL320',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 928,
                'name' => 'SL320',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            428 => 
            array (
                'code' => 'SL500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 929,
                'name' => 'SL500',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            429 => 
            array (
                'code' => 'SL550',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 930,
                'name' => 'SL550',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            430 => 
            array (
                'code' => 'SL55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 931,
                'name' => 'SL55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            431 => 
            array (
                'code' => 'SL600',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 932,
                'name' => 'SL600',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            432 => 
            array (
                'code' => 'SL63AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 933,
                'name' => 'SL63 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            433 => 
            array (
                'code' => 'SL65AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 934,
                'name' => 'SL65 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            434 => 
            array (
                'code' => 'SLK_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 935,
            'name' => 'SLK Class (8)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            435 => 
            array (
                'code' => 'SLK230',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 936,
                'name' => 'SLK230',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            436 => 
            array (
                'code' => 'SLK250',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 937,
                'name' => 'SLK250',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            437 => 
            array (
                'code' => 'SLK280',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 938,
                'name' => 'SLK280',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            438 => 
            array (
                'code' => 'SLK300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 939,
                'name' => 'SLK300',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            439 => 
            array (
                'code' => 'SLK320',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 940,
                'name' => 'SLK320',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            440 => 
            array (
                'code' => 'SLK32AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 941,
                'name' => 'SLK32 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            441 => 
            array (
                'code' => 'SLK350',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 942,
                'name' => 'SLK350',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            442 => 
            array (
                'code' => 'SLK55AMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 943,
                'name' => 'SLK55 AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            443 => 
            array (
                'code' => 'SLR_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 944,
            'name' => 'SLR Class (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            444 => 
            array (
                'code' => 'SLR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 945,
                'name' => 'SLR',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            445 => 
            array (
                'code' => 'SLS_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 946,
            'name' => 'SLS Class (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            446 => 
            array (
                'code' => 'SLSAMG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 947,
                'name' => 'SLS AMG',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            447 => 
            array (
                'code' => 'SPRINTER_CLASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 948,
            'name' => 'Sprinter Class (1)',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            448 => 
            array (
                'code' => 'MBSPRINTER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 949,
                'name' => 'Sprinter',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            449 => 
            array (
                'code' => 'MBOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 950,
                'name' => 'Other Mercedes-Benz Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 44,
            ),
            450 => 
            array (
                'code' => 'CAPRI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 951,
                'name' => 'Capri',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            451 => 
            array (
                'code' => 'COUGAR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 952,
                'name' => 'Cougar',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            452 => 
            array (
                'code' => 'MERCGRAND',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 953,
                'name' => 'Grand Marquis',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            453 => 
            array (
                'code' => 'LYNX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 954,
                'name' => 'Lynx',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            454 => 
            array (
                'code' => 'MARAUDER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 955,
                'name' => 'Marauder',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            455 => 
            array (
                'code' => 'MARINER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 956,
                'name' => 'Mariner',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            456 => 
            array (
                'code' => 'MARQ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 957,
                'name' => 'Marquis',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            457 => 
            array (
                'code' => 'MILAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 958,
                'name' => 'Milan',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            458 => 
            array (
                'code' => 'MONTEGO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 959,
                'name' => 'Montego',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            459 => 
            array (
                'code' => 'MONTEREY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 960,
                'name' => 'Monterey',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            460 => 
            array (
                'code' => 'MOUNTA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 961,
                'name' => 'Mountaineer',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            461 => 
            array (
                'code' => 'MYSTIQ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 962,
                'name' => 'Mystique',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            462 => 
            array (
                'code' => 'SABLE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 963,
                'name' => 'Sable',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            463 => 
            array (
                'code' => 'TOPAZ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 964,
                'name' => 'Topaz',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            464 => 
            array (
                'code' => 'TRACER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 965,
                'name' => 'Tracer',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            465 => 
            array (
                'code' => 'VILLA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 966,
                'name' => 'Villager',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            466 => 
            array (
                'code' => 'MERCZEP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 967,
                'name' => 'Zephyr',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            467 => 
            array (
                'code' => 'MEOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 968,
                'name' => 'Other Mercury Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 45,
            ),
            468 => 
            array (
                'code' => 'SCORP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 969,
                'name' => 'Scorpio',
                'updated_at' => NULL,
                'vehicle_make_id' => 46,
            ),
            469 => 
            array (
                'code' => 'XR4TI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 970,
                'name' => 'XR4Ti',
                'updated_at' => NULL,
                'vehicle_make_id' => 46,
            ),
            470 => 
            array (
                'code' => 'MEROTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 971,
                'name' => 'Other Merkur Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 46,
            ),
            471 => 
            array (
                'code' => 'COOPRCLUB_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 972,
            'name' => 'Cooper Clubman Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            472 => 
            array (
                'code' => 'COOPERCLUB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 973,
                'name' => 'Cooper Clubman',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            473 => 
            array (
                'code' => 'COOPRCLUBS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 974,
                'name' => 'Cooper S Clubman',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            474 => 
            array (
                'code' => 'COOPCOUNTRY_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 975,
            'name' => 'Cooper Countryman Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            475 => 
            array (
                'code' => 'COUNTRYMAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 976,
                'name' => 'Cooper Countryman',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            476 => 
            array (
                'code' => 'COUNTRYMNS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 977,
                'name' => 'Cooper S Countryman',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            477 => 
            array (
                'code' => 'COOPCOUP_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 978,
            'name' => 'Cooper Coupe Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            478 => 
            array (
                'code' => 'MINICOUPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 979,
                'name' => 'Cooper Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            479 => 
            array (
                'code' => 'MINISCOUPE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 980,
                'name' => 'Cooper S Coupe',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            480 => 
            array (
                'code' => 'COOPER_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 981,
            'name' => 'Cooper Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            481 => 
            array (
                'code' => 'COOPER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 982,
                'name' => 'Cooper',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            482 => 
            array (
                'code' => 'COOPERS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 983,
                'name' => 'Cooper S',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            483 => 
            array (
                'code' => 'COOPRROAD_MODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 984,
            'name' => 'Cooper Roadster Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            484 => 
            array (
                'code' => 'COOPERROAD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 985,
                'name' => 'Cooper Roadster',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            485 => 
            array (
                'code' => 'COOPERSRD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 986,
                'name' => 'Cooper S Roadster',
                'updated_at' => NULL,
                'vehicle_make_id' => 47,
            ),
            486 => 
            array (
                'code' => '3000GT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 987,
                'name' => '3000GT',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            487 => 
            array (
                'code' => 'CORD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 988,
                'name' => 'Cordia',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            488 => 
            array (
                'code' => 'DIAMAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 989,
                'name' => 'Diamante',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            489 => 
            array (
                'code' => 'ECLIP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 990,
                'name' => 'Eclipse',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            490 => 
            array (
                'code' => 'ENDEAVOR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 991,
                'name' => 'Endeavor',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            491 => 
            array (
                'code' => 'MITEXP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 992,
                'name' => 'Expo',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            492 => 
            array (
                'code' => 'GALANT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 993,
                'name' => 'Galant',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            493 => 
            array (
                'code' => 'MITI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 994,
                'name' => 'i',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            494 => 
            array (
                'code' => 'LANCERMITS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 995,
                'name' => 'Lancer',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            495 => 
            array (
                'code' => 'LANCEREVO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 996,
                'name' => 'Lancer Evolution',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            496 => 
            array (
                'code' => 'MITPU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 997,
                'name' => 'Mighty Max',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            497 => 
            array (
                'code' => 'MIRAGE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 998,
                'name' => 'Mirage',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            498 => 
            array (
                'code' => 'MONT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 999,
                'name' => 'Montero',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            499 => 
            array (
                'code' => 'MONTSPORT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1000,
                'name' => 'Montero Sport',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
        ));
        \DB::table('vehicle_models')->insert(array (
            0 => 
            array (
                'code' => 'OUTLANDER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1001,
                'name' => 'Outlander',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            1 => 
            array (
                'code' => 'OUTLANDSPT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1002,
                'name' => 'Outlander Sport',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            2 => 
            array (
                'code' => 'PRECIS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1003,
                'name' => 'Precis',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            3 => 
            array (
                'code' => 'RAIDERMITS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1004,
                'name' => 'Raider',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            4 => 
            array (
                'code' => 'SIGMA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1005,
                'name' => 'Sigma',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            5 => 
            array (
                'code' => 'MITSTAR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1006,
                'name' => 'Starion',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            6 => 
            array (
                'code' => 'TRED',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1007,
                'name' => 'Tredia',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            7 => 
            array (
                'code' => 'MITVAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1008,
                'name' => 'Van',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            8 => 
            array (
                'code' => 'MITOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1009,
                'name' => 'Other Mitsubishi Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 48,
            ),
            9 => 
            array (
                'code' => 'NIS200SX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1010,
                'name' => '200SX',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            10 => 
            array (
                'code' => '240SX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1011,
                'name' => '240SX',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            11 => 
            array (
                'code' => '300ZXTURBO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1012,
                'name' => '300ZX',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            12 => 
            array (
                'code' => '350Z',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1013,
                'name' => '350Z',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            13 => 
            array (
                'code' => '370Z',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1014,
                'name' => '370Z',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            14 => 
            array (
                'code' => 'ALTIMA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1015,
                'name' => 'Altima',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            15 => 
            array (
                'code' => 'PATHARMADA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1016,
                'name' => 'Armada',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            16 => 
            array (
                'code' => 'AXXESS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1017,
                'name' => 'Axxess',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            17 => 
            array (
                'code' => 'CUBE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1018,
                'name' => 'Cube',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            18 => 
            array (
                'code' => 'FRONTI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1019,
                'name' => 'Frontier',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            19 => 
            array (
                'code' => 'GT-R',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1020,
                'name' => 'GT-R',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            20 => 
            array (
                'code' => 'JUKE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1021,
                'name' => 'Juke',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            21 => 
            array (
                'code' => 'LEAF',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1022,
                'name' => 'Leaf',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            22 => 
            array (
                'code' => 'MAX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1023,
                'name' => 'Maxima',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            23 => 
            array (
                'code' => 'MURANO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1024,
                'name' => 'Murano',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            24 => 
            array (
                'code' => 'MURANOCROS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1025,
                'name' => 'Murano CrossCabriolet',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            25 => 
            array (
                'code' => 'NV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1026,
                'name' => 'NV',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            26 => 
            array (
                'code' => 'NX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1027,
                'name' => 'NX',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            27 => 
            array (
                'code' => 'PATH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1028,
                'name' => 'Pathfinder',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            28 => 
            array (
                'code' => 'NISPU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1029,
                'name' => 'Pickup',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            29 => 
            array (
                'code' => 'PULSAR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1030,
                'name' => 'Pulsar',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            30 => 
            array (
                'code' => 'QUEST',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1031,
                'name' => 'Quest',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            31 => 
            array (
                'code' => 'ROGUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1032,
                'name' => 'Rogue',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            32 => 
            array (
                'code' => 'SENTRA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1033,
                'name' => 'Sentra',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            33 => 
            array (
                'code' => 'STANZA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1034,
                'name' => 'Stanza',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            34 => 
            array (
                'code' => 'TITAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1035,
                'name' => 'Titan',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            35 => 
            array (
                'code' => 'NISVAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1036,
                'name' => 'Van',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            36 => 
            array (
                'code' => 'VERSA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1037,
                'name' => 'Versa',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            37 => 
            array (
                'code' => 'XTERRA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1038,
                'name' => 'Xterra',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            38 => 
            array (
                'code' => 'NISSOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1039,
                'name' => 'Other Nissan Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 49,
            ),
            39 => 
            array (
                'code' => '88',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1040,
                'name' => '88',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            40 => 
            array (
                'code' => 'ACHIEV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1041,
                'name' => 'Achieva',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            41 => 
            array (
                'code' => 'ALERO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1042,
                'name' => 'Alero',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            42 => 
            array (
                'code' => 'AURORA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1043,
                'name' => 'Aurora',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            43 => 
            array (
                'code' => 'BRAV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1044,
                'name' => 'Bravada',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            44 => 
            array (
                'code' => 'CUCR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1045,
                'name' => 'Custom Cruiser',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            45 => 
            array (
                'code' => 'OLDCUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1046,
                'name' => 'Cutlass',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            46 => 
            array (
                'code' => 'OLDCALAIS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1047,
                'name' => 'Cutlass Calais',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            47 => 
            array (
                'code' => 'CIERA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1048,
                'name' => 'Cutlass Ciera',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            48 => 
            array (
                'code' => 'CSUPR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1049,
                'name' => 'Cutlass Supreme',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            49 => 
            array (
                'code' => 'OLDSFIR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1050,
                'name' => 'Firenza',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            50 => 
            array (
                'code' => 'INTRIG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1051,
                'name' => 'Intrigue',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            51 => 
            array (
                'code' => '98',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1052,
                'name' => 'Ninety-Eight',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            52 => 
            array (
                'code' => 'OMEG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1053,
                'name' => 'Omega',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            53 => 
            array (
                'code' => 'REGEN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1054,
                'name' => 'Regency',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            54 => 
            array (
                'code' => 'SILHO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1055,
                'name' => 'Silhouette',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            55 => 
            array (
                'code' => 'TORO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1056,
                'name' => 'Toronado',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            56 => 
            array (
                'code' => 'OLDOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1057,
                'name' => 'Other Oldsmobile Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 50,
            ),
            57 => 
            array (
                'code' => '405',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1058,
                'name' => '405',
                'updated_at' => NULL,
                'vehicle_make_id' => 51,
            ),
            58 => 
            array (
                'code' => '504',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1059,
                'name' => '504',
                'updated_at' => NULL,
                'vehicle_make_id' => 51,
            ),
            59 => 
            array (
                'code' => '505',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1060,
                'name' => '505',
                'updated_at' => NULL,
                'vehicle_make_id' => 51,
            ),
            60 => 
            array (
                'code' => '604',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1061,
                'name' => '604',
                'updated_at' => NULL,
                'vehicle_make_id' => 51,
            ),
            61 => 
            array (
                'code' => 'UNAVAILPEU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1062,
                'name' => 'Other Peugeot Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 51,
            ),
            62 => 
            array (
                'code' => 'ACC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1063,
                'name' => 'Acclaim',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            63 => 
            array (
                'code' => 'ARROW',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1064,
                'name' => 'Arrow',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            64 => 
            array (
                'code' => 'BREEZE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1065,
                'name' => 'Breeze',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            65 => 
            array (
                'code' => 'CARAVE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1066,
                'name' => 'Caravelle',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            66 => 
            array (
                'code' => 'CHAMP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1067,
                'name' => 'Champ',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            67 => 
            array (
                'code' => 'COLT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1068,
                'name' => 'Colt',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            68 => 
            array (
                'code' => 'PLYMCONQ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1069,
                'name' => 'Conquest',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            69 => 
            array (
                'code' => 'GRANFURY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1070,
                'name' => 'Gran Fury',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            70 => 
            array (
                'code' => 'PLYMGRANV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1071,
                'name' => 'Grand Voyager',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            71 => 
            array (
                'code' => 'HORI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1072,
                'name' => 'Horizon',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            72 => 
            array (
                'code' => 'LASER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1073,
                'name' => 'Laser',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            73 => 
            array (
                'code' => 'NEON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1074,
                'name' => 'Neon',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            74 => 
            array (
                'code' => 'PROWLE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1075,
                'name' => 'Prowler',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            75 => 
            array (
                'code' => 'RELI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1076,
                'name' => 'Reliant',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            76 => 
            array (
                'code' => 'SAPPOROPLY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1077,
                'name' => 'Sapporo',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            77 => 
            array (
                'code' => 'SCAMP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1078,
                'name' => 'Scamp',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            78 => 
            array (
                'code' => 'SUNDAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1079,
                'name' => 'Sundance',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            79 => 
            array (
                'code' => 'TRAILDUST',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1080,
                'name' => 'Trailduster',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            80 => 
            array (
                'code' => 'VOYA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1081,
                'name' => 'Voyager',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            81 => 
            array (
                'code' => 'PLYOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1082,
                'name' => 'Other Plymouth Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 52,
            ),
            82 => 
            array (
                'code' => 'T-1000',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1083,
                'name' => '1000',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            83 => 
            array (
                'code' => '6000',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1084,
                'name' => '6000',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            84 => 
            array (
                'code' => 'AZTEK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1085,
                'name' => 'Aztek',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            85 => 
            array (
                'code' => 'BON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1086,
                'name' => 'Bonneville',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            86 => 
            array (
                'code' => 'CATALINA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1087,
                'name' => 'Catalina',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            87 => 
            array (
                'code' => 'FIERO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1088,
                'name' => 'Fiero',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            88 => 
            array (
                'code' => 'FBIRD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1089,
                'name' => 'Firebird',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            89 => 
            array (
                'code' => 'G3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1090,
                'name' => 'G3',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            90 => 
            array (
                'code' => 'G5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1091,
                'name' => 'G5',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            91 => 
            array (
                'code' => 'G6',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1092,
                'name' => 'G6',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            92 => 
            array (
                'code' => 'G8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1093,
                'name' => 'G8',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            93 => 
            array (
                'code' => 'GRNDAM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1094,
                'name' => 'Grand Am',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            94 => 
            array (
                'code' => 'GP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1095,
                'name' => 'Grand Prix',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            95 => 
            array (
                'code' => 'GTO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1096,
                'name' => 'GTO',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            96 => 
            array (
                'code' => 'J2000',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1097,
                'name' => 'J2000',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            97 => 
            array (
                'code' => 'LEMANS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1098,
                'name' => 'Le Mans',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            98 => 
            array (
                'code' => 'MONTANA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1099,
                'name' => 'Montana',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            99 => 
            array (
                'code' => 'PARISI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1100,
                'name' => 'Parisienne',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            100 => 
            array (
                'code' => 'PHOENIX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1101,
                'name' => 'Phoenix',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            101 => 
            array (
                'code' => 'SAFARIPONT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1102,
                'name' => 'Safari',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            102 => 
            array (
                'code' => 'SOLSTICE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1103,
                'name' => 'Solstice',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            103 => 
            array (
                'code' => 'SUNBIR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1104,
                'name' => 'Sunbird',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            104 => 
            array (
                'code' => 'SUNFIR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1105,
                'name' => 'Sunfire',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            105 => 
            array (
                'code' => 'TORRENT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1106,
                'name' => 'Torrent',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            106 => 
            array (
                'code' => 'TS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1107,
                'name' => 'Trans Sport',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            107 => 
            array (
                'code' => 'VIBE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1108,
                'name' => 'Vibe',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            108 => 
            array (
                'code' => 'PONOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1109,
                'name' => 'Other Pontiac Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 53,
            ),
            109 => 
            array (
                'code' => '911',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1110,
                'name' => '911',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            110 => 
            array (
                'code' => '924',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1111,
                'name' => '924',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            111 => 
            array (
                'code' => '928',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1112,
                'name' => '928',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            112 => 
            array (
                'code' => '944',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1113,
                'name' => '944',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            113 => 
            array (
                'code' => '968',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1114,
                'name' => '968',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            114 => 
            array (
                'code' => 'BOXSTE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1115,
                'name' => 'Boxster',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            115 => 
            array (
                'code' => 'CARRERAGT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1116,
                'name' => 'Carrera GT',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            116 => 
            array (
                'code' => 'CAYENNE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1117,
                'name' => 'Cayenne',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            117 => 
            array (
                'code' => 'CAYMAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1118,
                'name' => 'Cayman',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            118 => 
            array (
                'code' => 'PANAMERA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1119,
                'name' => 'Panamera',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            119 => 
            array (
                'code' => 'POROTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1120,
                'name' => 'Other Porsche Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 54,
            ),
            120 => 
            array (
                'code' => 'RAM1504WD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1121,
                'name' => '1500',
                'updated_at' => NULL,
                'vehicle_make_id' => 55,
            ),
            121 => 
            array (
                'code' => 'RAM25002WD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1122,
                'name' => '2500',
                'updated_at' => NULL,
                'vehicle_make_id' => 55,
            ),
            122 => 
            array (
                'code' => 'RAM3502WD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1123,
                'name' => '3500',
                'updated_at' => NULL,
                'vehicle_make_id' => 55,
            ),
            123 => 
            array (
                'code' => 'RAM4500',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1124,
                'name' => '4500',
                'updated_at' => NULL,
                'vehicle_make_id' => 55,
            ),
            124 => 
            array (
                'code' => '18I',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1125,
                'name' => '18i',
                'updated_at' => NULL,
                'vehicle_make_id' => 56,
            ),
            125 => 
            array (
                'code' => 'FU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1126,
                'name' => 'Fuego',
                'updated_at' => NULL,
                'vehicle_make_id' => 56,
            ),
            126 => 
            array (
                'code' => 'LECAR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1127,
                'name' => 'Le Car',
                'updated_at' => NULL,
                'vehicle_make_id' => 56,
            ),
            127 => 
            array (
                'code' => 'R18',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1128,
                'name' => 'R18',
                'updated_at' => NULL,
                'vehicle_make_id' => 56,
            ),
            128 => 
            array (
                'code' => 'RENSPORT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1129,
                'name' => 'Sportwagon',
                'updated_at' => NULL,
                'vehicle_make_id' => 56,
            ),
            129 => 
            array (
                'code' => 'UNAVAILREN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1130,
                'name' => 'Other Renault Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 56,
            ),
            130 => 
            array (
                'code' => 'CAMAR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1131,
                'name' => 'Camargue',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            131 => 
            array (
                'code' => 'CORN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1132,
                'name' => 'Corniche',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            132 => 
            array (
                'code' => 'GHOST',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1133,
                'name' => 'Ghost',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            133 => 
            array (
                'code' => 'PARKWARD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1134,
                'name' => 'Park Ward',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            134 => 
            array (
                'code' => 'PHANT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1135,
                'name' => 'Phantom',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            135 => 
            array (
                'code' => 'DAWN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1136,
                'name' => 'Silver Dawn',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            136 => 
            array (
                'code' => 'SILSERAPH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1137,
                'name' => 'Silver Seraph',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            137 => 
            array (
                'code' => 'RRSPIR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1138,
                'name' => 'Silver Spirit',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            138 => 
            array (
                'code' => 'SPUR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1139,
                'name' => 'Silver Spur',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            139 => 
            array (
                'code' => 'UNAVAILRR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1140,
                'name' => 'Other Rolls-Royce Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 57,
            ),
            140 => 
            array (
                'code' => '9-2X',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1141,
                'name' => '9-2X',
                'updated_at' => NULL,
                'vehicle_make_id' => 58,
            ),
            141 => 
            array (
                'code' => '9-3',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1142,
                'name' => '9-3',
                'updated_at' => NULL,
                'vehicle_make_id' => 58,
            ),
            142 => 
            array (
                'code' => '9-4X',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1143,
                'name' => '9-4X',
                'updated_at' => NULL,
                'vehicle_make_id' => 58,
            ),
            143 => 
            array (
                'code' => '9-5',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1144,
                'name' => '9-5',
                'updated_at' => NULL,
                'vehicle_make_id' => 58,
            ),
            144 => 
            array (
                'code' => '97X',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1145,
                'name' => '9-7X',
                'updated_at' => NULL,
                'vehicle_make_id' => 58,
            ),
            145 => 
            array (
                'code' => '900',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1146,
                'name' => '900',
                'updated_at' => NULL,
                'vehicle_make_id' => 58,
            ),
            146 => 
            array (
                'code' => '9000',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1147,
                'name' => '9000',
                'updated_at' => NULL,
                'vehicle_make_id' => 58,
            ),
            147 => 
            array (
                'code' => 'SAOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1148,
                'name' => 'Other Saab Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 58,
            ),
            148 => 
            array (
                'code' => 'ASTRA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1149,
                'name' => 'Astra',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            149 => 
            array (
                'code' => 'AURA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1150,
                'name' => 'Aura',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            150 => 
            array (
                'code' => 'ION',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1151,
                'name' => 'ION',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            151 => 
            array (
                'code' => 'L_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1152,
            'name' => 'L Series (3)',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            152 => 
            array (
                'code' => 'L100',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1153,
                'name' => 'L100',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            153 => 
            array (
                'code' => 'L200',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1154,
                'name' => 'L200',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            154 => 
            array (
                'code' => 'L300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1155,
                'name' => 'L300',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            155 => 
            array (
                'code' => 'LSSATURN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1156,
                'name' => 'LS',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            156 => 
            array (
                'code' => 'LW_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1157,
            'name' => 'LW Series (4)',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            157 => 
            array (
                'code' => 'LW',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1158,
                'name' => 'LW1',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            158 => 
            array (
                'code' => 'LW2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1159,
                'name' => 'LW2',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            159 => 
            array (
                'code' => 'LW200',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1160,
                'name' => 'LW200',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            160 => 
            array (
                'code' => 'LW300',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1161,
                'name' => 'LW300',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            161 => 
            array (
                'code' => 'OUTLOOK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1162,
                'name' => 'Outlook',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            162 => 
            array (
                'code' => 'RELAY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1163,
                'name' => 'Relay',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            163 => 
            array (
                'code' => 'SC_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1164,
            'name' => 'SC Series (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            164 => 
            array (
                'code' => 'SC1',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1165,
                'name' => 'SC1',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            165 => 
            array (
                'code' => 'SC2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1166,
                'name' => 'SC2',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            166 => 
            array (
                'code' => 'SKY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1167,
                'name' => 'Sky',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            167 => 
            array (
                'code' => 'SL_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1168,
            'name' => 'SL Series (3)',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            168 => 
            array (
                'code' => 'SL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1169,
                'name' => 'SL',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            169 => 
            array (
                'code' => 'SL1',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1170,
                'name' => 'SL1',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            170 => 
            array (
                'code' => 'SL2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1171,
                'name' => 'SL2',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            171 => 
            array (
                'code' => 'SW_SERIES',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1172,
            'name' => 'SW Series (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            172 => 
            array (
                'code' => 'SW1',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1173,
                'name' => 'SW1',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            173 => 
            array (
                'code' => 'SW2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1174,
                'name' => 'SW2',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            174 => 
            array (
                'code' => 'VUE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1175,
                'name' => 'Vue',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            175 => 
            array (
                'code' => 'SATOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1176,
                'name' => 'Other Saturn Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 59,
            ),
            176 => 
            array (
                'code' => 'SCIFRS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1177,
                'name' => 'FR-S',
                'updated_at' => NULL,
                'vehicle_make_id' => 60,
            ),
            177 => 
            array (
                'code' => 'IQ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1178,
                'name' => 'iQ',
                'updated_at' => NULL,
                'vehicle_make_id' => 60,
            ),
            178 => 
            array (
                'code' => 'TC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1179,
                'name' => 'tC',
                'updated_at' => NULL,
                'vehicle_make_id' => 60,
            ),
            179 => 
            array (
                'code' => 'XA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1180,
                'name' => 'xA',
                'updated_at' => NULL,
                'vehicle_make_id' => 60,
            ),
            180 => 
            array (
                'code' => 'XB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1181,
                'name' => 'xB',
                'updated_at' => NULL,
                'vehicle_make_id' => 60,
            ),
            181 => 
            array (
                'code' => 'XD',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1182,
                'name' => 'xD',
                'updated_at' => NULL,
                'vehicle_make_id' => 60,
            ),
            182 => 
            array (
                'code' => 'FORTWO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1183,
                'name' => 'fortwo',
                'updated_at' => NULL,
                'vehicle_make_id' => 61,
            ),
            183 => 
            array (
                'code' => 'SMOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1184,
                'name' => 'Other smart Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 61,
            ),
            184 => 
            array (
                'code' => 'SRTVIPER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1185,
                'name' => 'Viper',
                'updated_at' => NULL,
                'vehicle_make_id' => 62,
            ),
            185 => 
            array (
                'code' => '825',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1186,
                'name' => '825',
                'updated_at' => NULL,
                'vehicle_make_id' => 63,
            ),
            186 => 
            array (
                'code' => '827',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1187,
                'name' => '827',
                'updated_at' => NULL,
                'vehicle_make_id' => 63,
            ),
            187 => 
            array (
                'code' => 'UNAVAILSTE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1188,
                'name' => 'Other Sterling Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 63,
            ),
            188 => 
            array (
                'code' => 'BAJA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1189,
                'name' => 'Baja',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            189 => 
            array (
                'code' => 'BRAT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1190,
                'name' => 'Brat',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            190 => 
            array (
                'code' => 'SUBBRZ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1191,
                'name' => 'BRZ',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            191 => 
            array (
                'code' => 'FOREST',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1192,
                'name' => 'Forester',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            192 => 
            array (
                'code' => 'IMPREZ',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1193,
                'name' => 'Impreza',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            193 => 
            array (
                'code' => 'IMPWRX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1194,
                'name' => 'Impreza WRX',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            194 => 
            array (
                'code' => 'JUSTY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1195,
                'name' => 'Justy',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            195 => 
            array (
                'code' => 'SUBL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1196,
                'name' => 'L Series',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            196 => 
            array (
                'code' => 'LEGACY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1197,
                'name' => 'Legacy',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            197 => 
            array (
                'code' => 'LOYALE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1198,
                'name' => 'Loyale',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            198 => 
            array (
                'code' => 'SUBOUTBK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1199,
                'name' => 'Outback',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            199 => 
            array (
                'code' => 'SVX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1200,
                'name' => 'SVX',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            200 => 
            array (
                'code' => 'B9TRIBECA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1201,
                'name' => 'Tribeca',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            201 => 
            array (
                'code' => 'XT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1202,
                'name' => 'XT',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            202 => 
            array (
                'code' => 'XVCRSSTREK',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1203,
                'name' => 'XV Crosstrek',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            203 => 
            array (
                'code' => 'SUBOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1204,
                'name' => 'Other Subaru Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 64,
            ),
            204 => 
            array (
                'code' => 'AERIO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1205,
                'name' => 'Aerio',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            205 => 
            array (
                'code' => 'EQUATOR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1206,
                'name' => 'Equator',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            206 => 
            array (
                'code' => 'ESTEEM',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1207,
                'name' => 'Esteem',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            207 => 
            array (
                'code' => 'FORENZA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1208,
                'name' => 'Forenza',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            208 => 
            array (
                'code' => 'GRANDV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1209,
                'name' => 'Grand Vitara',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            209 => 
            array (
                'code' => 'KIZASHI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1210,
                'name' => 'Kizashi',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            210 => 
            array (
                'code' => 'RENO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1211,
                'name' => 'Reno',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            211 => 
            array (
                'code' => 'SAMUR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1212,
                'name' => 'Samurai',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            212 => 
            array (
                'code' => 'SIDE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1213,
                'name' => 'Sidekick',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            213 => 
            array (
                'code' => 'SWIFT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1214,
                'name' => 'Swift',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            214 => 
            array (
                'code' => 'SX4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1215,
                'name' => 'SX4',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            215 => 
            array (
                'code' => 'VERONA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1216,
                'name' => 'Verona',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            216 => 
            array (
                'code' => 'VITARA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1217,
                'name' => 'Vitara',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            217 => 
            array (
                'code' => 'X90',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1218,
                'name' => 'X-90',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            218 => 
            array (
                'code' => 'XL7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1219,
                'name' => 'XL7',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            219 => 
            array (
                'code' => 'SUZOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1220,
                'name' => 'Other Suzuki Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 65,
            ),
            220 => 
            array (
                'code' => 'ROADSTER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1221,
                'name' => 'Roadster',
                'updated_at' => NULL,
                'vehicle_make_id' => 66,
            ),
            221 => 
            array (
                'code' => '4RUN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1222,
                'name' => '4Runner',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            222 => 
            array (
                'code' => 'AVALON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1223,
                'name' => 'Avalon',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            223 => 
            array (
                'code' => 'CAMRY',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1224,
                'name' => 'Camry',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            224 => 
            array (
                'code' => 'CELICA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1225,
                'name' => 'Celica',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            225 => 
            array (
                'code' => 'COROL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1226,
                'name' => 'Corolla',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            226 => 
            array (
                'code' => 'CORONA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1227,
                'name' => 'Corona',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            227 => 
            array (
                'code' => 'CRESS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1228,
                'name' => 'Cressida',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            228 => 
            array (
                'code' => 'ECHO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1229,
                'name' => 'Echo',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            229 => 
            array (
                'code' => 'FJCRUIS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1230,
                'name' => 'FJ Cruiser',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            230 => 
            array (
                'code' => 'HIGHLANDER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1231,
                'name' => 'Highlander',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            231 => 
            array (
                'code' => 'LC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1232,
                'name' => 'Land Cruiser',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            232 => 
            array (
                'code' => 'MATRIX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1233,
                'name' => 'Matrix',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            233 => 
            array (
                'code' => 'MR2',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1234,
                'name' => 'MR2',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            234 => 
            array (
                'code' => 'MR2SPYDR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1235,
                'name' => 'MR2 Spyder',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            235 => 
            array (
                'code' => 'PASEO',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1236,
                'name' => 'Paseo',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            236 => 
            array (
                'code' => 'PICKUP',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1237,
                'name' => 'Pickup',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            237 => 
            array (
                'code' => 'PREVIA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1238,
                'name' => 'Previa',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            238 => 
            array (
                'code' => 'PRIUS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1239,
                'name' => 'Prius',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            239 => 
            array (
                'code' => 'PRIUSC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1240,
                'name' => 'Prius C',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            240 => 
            array (
                'code' => 'PRIUSV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1241,
                'name' => 'Prius V',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            241 => 
            array (
                'code' => 'RAV4',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1242,
                'name' => 'RAV4',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            242 => 
            array (
                'code' => 'SEQUOIA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1243,
                'name' => 'Sequoia',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            243 => 
            array (
                'code' => 'SIENNA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1244,
                'name' => 'Sienna',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            244 => 
            array (
                'code' => 'SOLARA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1245,
                'name' => 'Solara',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            245 => 
            array (
                'code' => 'STARLET',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1246,
                'name' => 'Starlet',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            246 => 
            array (
                'code' => 'SUPRA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1247,
                'name' => 'Supra',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            247 => 
            array (
                'code' => 'T100',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1248,
                'name' => 'T100',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            248 => 
            array (
                'code' => 'TACOMA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1249,
                'name' => 'Tacoma',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            249 => 
            array (
                'code' => 'TERCEL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1250,
                'name' => 'Tercel',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            250 => 
            array (
                'code' => 'TUNDRA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1251,
                'name' => 'Tundra',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            251 => 
            array (
                'code' => 'TOYVAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1252,
                'name' => 'Van',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            252 => 
            array (
                'code' => 'VENZA',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1253,
                'name' => 'Venza',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            253 => 
            array (
                'code' => 'YARIS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1254,
                'name' => 'Yaris',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            254 => 
            array (
                'code' => 'TOYOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1255,
                'name' => 'Other Toyota Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 67,
            ),
            255 => 
            array (
                'code' => 'TR7',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1256,
                'name' => 'TR7',
                'updated_at' => NULL,
                'vehicle_make_id' => 68,
            ),
            256 => 
            array (
                'code' => 'TR8',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1257,
                'name' => 'TR8',
                'updated_at' => NULL,
                'vehicle_make_id' => 68,
            ),
            257 => 
            array (
                'code' => 'TRIOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1258,
                'name' => 'Other Triumph Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 68,
            ),
            258 => 
            array (
                'code' => 'BEETLE',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1259,
                'name' => 'Beetle',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            259 => 
            array (
                'code' => 'VOLKSCAB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1260,
                'name' => 'Cabrio',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            260 => 
            array (
                'code' => 'CAB',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1261,
                'name' => 'Cabriolet',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            261 => 
            array (
                'code' => 'CC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1262,
                'name' => 'CC',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            262 => 
            array (
                'code' => 'CORR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1263,
                'name' => 'Corrado',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            263 => 
            array (
                'code' => 'DASHER',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1264,
                'name' => 'Dasher',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            264 => 
            array (
                'code' => 'EOS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1265,
                'name' => 'Eos',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            265 => 
            array (
                'code' => 'EUROVAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1266,
                'name' => 'Eurovan',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            266 => 
            array (
                'code' => 'VOLKSFOX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1267,
                'name' => 'Fox',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            267 => 
            array (
                'code' => 'GLI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1268,
                'name' => 'GLI',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            268 => 
            array (
                'code' => 'GOLFR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1269,
                'name' => 'Golf R',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            269 => 
            array (
                'code' => 'GTI',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1270,
                'name' => 'GTI',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            270 => 
            array (
                'code' => 'GOLFANDRABBITMODELS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1271,
            'name' => 'Golf and Rabbit Models (2)',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            271 => 
            array (
                'code' => 'GOLF',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1272,
                'name' => 'Golf',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            272 => 
            array (
                'code' => 'RABBIT',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1273,
                'name' => 'Rabbit',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            273 => 
            array (
                'code' => 'JET',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1274,
                'name' => 'Jetta',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            274 => 
            array (
                'code' => 'PASS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1275,
                'name' => 'Passat',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            275 => 
            array (
                'code' => 'PHAETON',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1276,
                'name' => 'Phaeton',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            276 => 
            array (
                'code' => 'RABBITPU',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1277,
                'name' => 'Pickup',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            277 => 
            array (
                'code' => 'QUAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1278,
                'name' => 'Quantum',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            278 => 
            array (
                'code' => 'R32',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1279,
                'name' => 'R32',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            279 => 
            array (
                'code' => 'ROUTAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1280,
                'name' => 'Routan',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            280 => 
            array (
                'code' => 'SCIR',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1281,
                'name' => 'Scirocco',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            281 => 
            array (
                'code' => 'TIGUAN',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1282,
                'name' => 'Tiguan',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            282 => 
            array (
                'code' => 'TOUAREG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1283,
                'name' => 'Touareg',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            283 => 
            array (
                'code' => 'VANAG',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1284,
                'name' => 'Vanagon',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            284 => 
            array (
                'code' => 'VWOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1285,
                'name' => 'Other Volkswagen Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 69,
            ),
            285 => 
            array (
                'code' => '240',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1286,
                'name' => '240',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            286 => 
            array (
                'code' => '260',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1287,
                'name' => '260',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            287 => 
            array (
                'code' => '740',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1288,
                'name' => '740',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            288 => 
            array (
                'code' => '760',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1289,
                'name' => '760',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            289 => 
            array (
                'code' => '780',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1290,
                'name' => '780',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            290 => 
            array (
                'code' => '850',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1291,
                'name' => '850',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            291 => 
            array (
                'code' => '940',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1292,
                'name' => '940',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            292 => 
            array (
                'code' => '960',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1293,
                'name' => '960',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            293 => 
            array (
                'code' => 'C30',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1294,
                'name' => 'C30',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            294 => 
            array (
                'code' => 'C70',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1295,
                'name' => 'C70',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            295 => 
            array (
                'code' => 'S40',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1296,
                'name' => 'S40',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            296 => 
            array (
                'code' => 'S60',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1297,
                'name' => 'S60',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            297 => 
            array (
                'code' => 'S70',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1298,
                'name' => 'S70',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            298 => 
            array (
                'code' => 'S80',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1299,
                'name' => 'S80',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            299 => 
            array (
                'code' => 'S90',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1300,
                'name' => 'S90',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            300 => 
            array (
                'code' => 'V40',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1301,
                'name' => 'V40',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            301 => 
            array (
                'code' => 'V50',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1302,
                'name' => 'V50',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            302 => 
            array (
                'code' => 'V70',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1303,
                'name' => 'V70',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            303 => 
            array (
                'code' => 'V90',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1304,
                'name' => 'V90',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            304 => 
            array (
                'code' => 'XC60',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1305,
                'name' => 'XC60',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            305 => 
            array (
                'code' => 'XC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1306,
                'name' => 'XC70',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            306 => 
            array (
                'code' => 'XC90',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1307,
                'name' => 'XC90',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            307 => 
            array (
                'code' => 'VOLOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1308,
                'name' => 'Other Volvo Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 70,
            ),
            308 => 
            array (
                'code' => 'GV',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1309,
                'name' => 'GV',
                'updated_at' => NULL,
                'vehicle_make_id' => 71,
            ),
            309 => 
            array (
                'code' => 'GVC',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1310,
                'name' => 'GVC',
                'updated_at' => NULL,
                'vehicle_make_id' => 71,
            ),
            310 => 
            array (
                'code' => 'GVL',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1311,
                'name' => 'GVL',
                'updated_at' => NULL,
                'vehicle_make_id' => 71,
            ),
            311 => 
            array (
                'code' => 'GVS',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1312,
                'name' => 'GVS',
                'updated_at' => NULL,
                'vehicle_make_id' => 71,
            ),
            312 => 
            array (
                'code' => 'GVX',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1313,
                'name' => 'GVX',
                'updated_at' => NULL,
                'vehicle_make_id' => 71,
            ),
            313 => 
            array (
                'code' => 'YUOTH',
                'created_at' => NULL,
                'deleted_at' => NULL,
                'id' => 1314,
                'name' => 'Other Yugo Models',
                'updated_at' => NULL,
                'vehicle_make_id' => 71,
            ),
        ));
        
        
    }
}