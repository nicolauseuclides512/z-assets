<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class UpdateAreaAssetsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        #COUNTRY
        $countriesCsvFile = base_path() . "/public/src/rajaongkir_negara.csv";
        $countriesCsvResult = \App\Utils\CsvConverter::csvToArray($countriesCsvFile);

        array_map(function ($x) {
            $country = \App\Models\AssetCountry::inst()->getByIdRef($x['country_id'])->first();
            if ($country) {
//                $country->id = $x['country_id'];
//                $country->code = null;
                $country->name = ucfirst(strtolower($x["country_name"]));
                $country->status = $x['status'];
                if (!$country->save())
                    Log::error("update Country. [ $country->id ]" . json_encode($country->errors));
            }
        }, $countriesCsvResult);

        printf('Update country done ');

        $countryId = 236;

        #PROVINCE
        $provincesCsvFile = base_path() . "/public/src/rajaongkir_propinsi.csv";
        $provincesCsvResult = \App\Utils\CsvConverter::csvToArray($provincesCsvFile);

        array_map(function ($x) use ($countryId) {
            $province = \App\Models\AssetProvince::inst()->getByIdRef($x["province_id"])->first();
            if ($province) {
                $province->country_id = $countryId; //TODO(): whats
//                $province->id = $x["province_id"];
                $province->name = $x["province_name"];
                $province->status = true;
                if (!$province->save())
                    Log::error("update province failed. [ $province->id ] " . json_encode($province->errors));
            }
        }, $provincesCsvResult);

        printf('Update province done ');

        #DISTRICT
        $districtsCsvFile = base_path() . "/public/src/rajaongkir_kabupaten.csv";
        $districtsCsvResult = \App\Utils\CsvConverter::csvToArray($districtsCsvFile);

        array_map(function ($x) {
            $district = \App\Models\AssetDistrict::inst()->getByIdRef($x['district_id'])->first();
            if ($district) {
                $district->province_id = $x['province_id'];
//                $district->id = $x['district_id'];
                $district->name = $x['district_name'];
                $district->type = "city";
                $district->zip = $x['postal_code'];
                $district->status = true;
                if (!$district->save())
                    Log::error("update district failed. [ $district->id ] " . json_encode($district->errors));
            }
        }, $districtsCsvResult);

        printf('Update district done ');

        #REGION
        $regionsCsvFile = base_path() . "/public/src/rajaongkir_kecamatan.csv";
        $regionsCsvResult = \App\Utils\CsvConverter::csvToArray($regionsCsvFile);

        array_map(function ($x) {
            $region = \App\Models\AssetRegion::inst()->getByIdRef($x['region_id'])->first();
            $region->district_id = $x['district_id'];
//            $region->id = $x['region_id'];
            $region->name = $x['region_name'];
            $region->zip = null;
            $region->type = "subdistrict";
            $region->status = true;
            if (!$region->save())
                Log::error("update region failed. [ $region->id ]" . json_encode($region->errors));
        }, $regionsCsvResult);

        printf('Update region done ');

    }
}
