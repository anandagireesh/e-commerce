<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ini_set('memory_limit', '256G');
        $jsonPath = public_path('data/locations.json');
        $jsonData = json_decode(file_get_contents($jsonPath), true);
        foreach ($jsonData as $json) {
            $country = [
                'country' => $json['name'],
                'iso2' => $json['iso2'],
                'iso3' => $json['iso3'],
                'phone_code' => '+' . $json['phonecode'],
                'capital' => $json['capital'],
                'currency' => $json['currency'],
                'native' => $json['native'],
                'emoji' => $json['emoji'],
                'currency_name' => $json['currency_name'],
                'currency_symbol' => $json['currency_symbol'],
                'region' => $json['region'],
                'subregion' => $json['subregion'],
                'nationality' => $json['nationality'],
                'time_zone_name' => $json['timezones'][0]['zoneName'],
                'gmt_offset' => $json['timezones'][0]['gmtOffset'],
                'gmt_offset_name' => $json['timezones'][0]['gmtOffsetName'],
                'abbreviation' => $json['timezones'][0]['abbreviation'],
                'tz_name' => $json['timezones'][0]['tzName'],
                'emojiU' => $json['emojiU'],
                'latitude' => $json['latitude'],
                'longitude' => $json['longitude'],
                'created_at' => now(),
                'updated_at' => now(),
            ];
            $countryId = DB::table('countries')->insertGetId($country);
            // $countryId = 1;
            if (isset($json['states'])) {
                $states = $json['states'];
                foreach ($states as $state) {

                    $stateData = [
                        'country_id' => $countryId,
                        'country_code' => $state['state_code'],
                        'iso2' => $json['iso2'],
                        'state' => $state['name'],
                        'latitude' => $state['latitude'],
                        'longitude' => $state['longitude'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ];
                    DB::table('states')->insertGetId($stateData);
                }
            }
        }
    }
}
