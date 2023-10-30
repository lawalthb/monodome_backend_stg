<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class LoadDocumentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('load_documents')->delete();
        
        \DB::table('load_documents')->insert(array (
            0 => 
            array (
                'id' => 1,
                'uuid' => 'e2541ef8-0c8a-4ace-b076-957a2052f6c4',
                'name' => '1698672302qDxhNFotJz.PNG',
                'path' => 'uploads/vehicle_image/1698672302qDxhNFotJz.PNG',
                'loadable_id' => 1,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:02',
                'updated_at' => '2023-10-30 13:25:02',
            ),
            1 => 
            array (
                'id' => 2,
                'uuid' => '71cf8e46-765a-4928-b421-684b20595038',
                'name' => '1698672302LZuwMxc09s.PNG',
                'path' => 'uploads/vehicle_image/1698672302LZuwMxc09s.PNG',
                'loadable_id' => 1,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:02',
                'updated_at' => '2023-10-30 13:25:02',
            ),
            2 => 
            array (
                'id' => 3,
                'uuid' => 'be55797c-dbf4-4077-b43e-ae3a44d8c155',
                'name' => '1698672322uwoGGFHF1k.PNG',
                'path' => 'uploads/vehicle_image/1698672322uwoGGFHF1k.PNG',
                'loadable_id' => 2,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:22',
                'updated_at' => '2023-10-30 13:25:22',
            ),
            3 => 
            array (
                'id' => 4,
                'uuid' => 'fffe4298-4ebc-4766-af40-4dfcd47d0d07',
                'name' => '1698672322IZYGufenGY.PNG',
                'path' => 'uploads/vehicle_image/1698672322IZYGufenGY.PNG',
                'loadable_id' => 2,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:22',
                'updated_at' => '2023-10-30 13:25:22',
            ),
            4 => 
            array (
                'id' => 5,
                'uuid' => 'a62f79a1-c52d-4855-868a-14ae8c68479b',
                'name' => '1698672329h3j2lCGioB.PNG',
                'path' => 'uploads/vehicle_image/1698672329h3j2lCGioB.PNG',
                'loadable_id' => 3,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:29',
                'updated_at' => '2023-10-30 13:25:29',
            ),
            5 => 
            array (
                'id' => 6,
                'uuid' => '9c2bbc30-fca3-4278-80ad-141062939465',
                'name' => '1698672329BawAKQJ72L.PNG',
                'path' => 'uploads/vehicle_image/1698672329BawAKQJ72L.PNG',
                'loadable_id' => 3,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:29',
                'updated_at' => '2023-10-30 13:25:29',
            ),
            6 => 
            array (
                'id' => 7,
                'uuid' => '11f0ae0d-983c-4614-a0e6-cd7a8d81a7b7',
                'name' => '1698672342P6UyVLgegc.PNG',
                'path' => 'uploads/vehicle_image/1698672342P6UyVLgegc.PNG',
                'loadable_id' => 4,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:42',
                'updated_at' => '2023-10-30 13:25:42',
            ),
            7 => 
            array (
                'id' => 8,
                'uuid' => 'ef1de886-d71b-46db-a739-43e14c9557e7',
                'name' => '1698672342chQ0cluid9.PNG',
                'path' => 'uploads/vehicle_image/1698672342chQ0cluid9.PNG',
                'loadable_id' => 4,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:42',
                'updated_at' => '2023-10-30 13:25:42',
            ),
            8 => 
            array (
                'id' => 9,
                'uuid' => '9bd527e6-8caa-48aa-bd6a-f07b09580a19',
                'name' => '1698672359hWDl7pWtFq.PNG',
                'path' => 'uploads/vehicle_image/1698672359hWDl7pWtFq.PNG',
                'loadable_id' => 5,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:59',
                'updated_at' => '2023-10-30 13:25:59',
            ),
            9 => 
            array (
                'id' => 10,
                'uuid' => '38fedfc2-4882-4a2f-81d3-b4de377f07ba',
                'name' => '1698672359NUCaYuiX1k.PNG',
                'path' => 'uploads/vehicle_image/1698672359NUCaYuiX1k.PNG',
                'loadable_id' => 5,
                'loadable_type' => 'App\\Models\\Driver',
                'created_at' => '2023-10-30 13:25:59',
                'updated_at' => '2023-10-30 13:25:59',
            ),
            10 => 
            array (
                'id' => 11,
                'uuid' => '7acc6ba0-8c71-44d4-8bd5-74bb902c0802',
                'name' => 'outside of the truck',
                'path' => 'uploads/load_documents/1698673166vRrjuiQeZB.PNG',
                'loadable_id' => 1,
                'loadable_type' => 'App\\Models\\Truck',
                'created_at' => '2023-10-30 13:39:26',
                'updated_at' => '2023-10-30 13:39:26',
            ),
            11 => 
            array (
                'id' => 12,
                'uuid' => 'c47d4dc6-6522-4e0a-ae95-2266b087371e',
                'name' => 'Truck\'s document',
                'path' => 'uploads/load_documents/1698673166zlqrKadVNY.PNG',
                'loadable_id' => 1,
                'loadable_type' => 'App\\Models\\Truck',
                'created_at' => '2023-10-30 13:39:26',
                'updated_at' => '2023-10-30 13:39:26',
            ),
        ));
        
        
    }
}