<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('countries')->delete();

        DB::table('countries')->insert(array(
            1 =>
            array(
                'id' => 1,
                'name' => 'Nigeria',
                'iso3' => 'NGA',
                'iso2' => 'NG',
                'phonecode' => '234',
                'capital' => 'Abuja',
                'currency' => 'NGN',
                'currency_symbol' => '₦',
                'tld' => '.ng',
                'native' => 'Nigeria',
                'region' => 'Africa',
                'subregion' => 'Western Africa',
                'timezones' => '[{"zoneName":"Africa\\/Lagos","gmtOffset":3600,"gmtOffsetName":"UTC+01:00","abbreviation":"WAT","tzName":"West Africa Time"}]',
                'translations' => '{"br":"Nigéria","pt":"Nigéria","nl":"Nigeria","hr":"Nigerija","fa":"نیجریه","de":"Nigeria","es":"Nigeria","fr":"Nigéria","ja":"ナイジェリア","it":"Nigeria"}',
                'latitude' => '10.00000000',
                'longitude' => '8.00000000',
                'emoji' => '🇳🇬',
                'emojiU' => 'U+1F1F3 U+1F1EC',
                'created_at' => '2018-07-20 20:11:03',
                'updated_at' => '2021-02-20 14:24:49',
                'flag' => 1,
                'wikiDataId' => 'Q1033',
            ),

        )
        );
    }
}
