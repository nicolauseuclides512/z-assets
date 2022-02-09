<?php

use App\Models\AssetCarrier;
use App\Models\AssetPaymentMethod;
use App\Models\AssetWeightUnit;
use App\Utils\CsvConverter;
use Illuminate\Support\Facades\Log;

/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

class NewAssetTableSeeder extends \Illuminate\Database\Seeder
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
            $country = \App\Models\AssetCountry::inst();
            $country->id = $x['country_id'];
            $country->code = null;
            $country->name = ucfirst(strtolower($x["country_name"]));
            $country->status = $x['status'];
            if (!$country->save())
                Log::error("Country. [ $country->id ]" . json_encode($country->errors));
        }, $countriesCsvResult);

        printf('Seed country done ');

        $countryId = 236;

        #PROVINCE
        $provincesCsvFile = base_path() . "/public/src/rajaongkir_propinsi.csv";
        $provincesCsvResult = \App\Utils\CsvConverter::csvToArray($provincesCsvFile);

        array_map(function ($x) use ($countryId) {
            $province = \App\Models\AssetProvince::inst();
            $province->country_id = $countryId; //TODO(): whats
            $province->id = $x["province_id"];
            $province->name = $x["province_name"];
            $province->status = true;
            if (!$province->save())
                Log::error("province failed. [ $province->id ] " . json_encode($province->errors));
        }, $provincesCsvResult);

        printf('Seed province done ');

        #DISTRICT
        $districtsCsvFile = base_path() . "/public/src/rajaongkir_kabupaten.csv";
        $districtsCsvResult = \App\Utils\CsvConverter::csvToArray($districtsCsvFile);

        array_map(function ($x) {
            $district = \App\Models\AssetDistrict::inst();
            $district->province_id = $x['province_id'];
            $district->id = $x['district_id'];
            $district->name = $x['district_name'];
            $district->type = "city";
            $district->zip = $x['postal_code'];
            $district->status = true;
            if (!$district->save())
                Log::error("district failed. [ $district->id ] " . json_encode($district->errors));
        }, $districtsCsvResult);

        printf('Seed district done ');

        #REGION
        $regionsCsvFile = base_path() . "/public/src/rajaongkir_kecamatan.csv";
        $regionsCsvResult = \App\Utils\CsvConverter::csvToArray($regionsCsvFile);

        array_map(function ($x) {
            $region = \App\Models\AssetRegion::inst();
            $region->district_id = $x['district_id'];
            $region->id = $x['region_id'];
            $region->name = $x['region_name'];
            $region->zip = null;
            $region->type = "subdistrict";
            $region->status = true;
            if (!$region->save())
                Log::error("region failed. [ $region->id ]" . json_encode($region->errors));
        }, $regionsCsvResult);

        printf('Seed region done ');

        #TIMEZONE
        $tzCsvFile = base_path() . "/public/src/time_zones.csv";
        $tzCsvResult = \App\Utils\CsvConverter::csvToArray($tzCsvFile);

        array_map(function ($x) {
            $tz = \App\Models\AssetTimezone::inst();
            $tz->name = $x['name'];
            $tz->zone = $x['offset'];
            $tz->status = $x['status'];
            if (!$tz->save())
                Log::error('timezone failed. ' . json_encode($tz->errors));

        }, $tzCsvResult);

        printf('Seed Timezone done ');

        #CURRENCY
        array_map(function ($x) {
            $currency = \App\Models\AssetCurrency::inst();
            $currency->code = $x[0];
            $currency->symbol = $x[1];
            $currency->name = $x[2];
            $currency->iso_2 = "";
            $currency->iso_3 = "";
            $currency->status = $x[3];
            if (!$currency->save())
                Log::error('Currency failed, ' . json_encode($currency->errors));

        }, [["IDR", "RP", "Rupiah", true], ["USD", "$", "Dollar", false]]);

        printf('Seed currency done ');


        #LOCALE
        $localesCsvFile = base_path() . "/public/src/locales.csv";
        $localesCsvResult = \App\Utils\CsvConverter::csvToArray($localesCsvFile);
        array_map(function ($x) {
            $locale = \App\Models\AssetLanguage::inst();
            $locale->code = $x['code'];
            $locale->name = $x['name'];
            $locale->status = $x['status'];
            if (!$locale->save())
                Log::error('locale failed, ' . json_encode($locale->errors));
        }, $localesCsvResult);

        printf('Seed language done ');

        #ASSET BANK
        $banksCsvFile = base_path() . "/public/src/banks.csv";
        $banksCsvResult = CsvConverter::csvToArray($banksCsvFile);

        array_map(function ($x) {
            $bank = \App\Models\AssetBank::inst();
            $bank->name = $x['name'];
            $bank->logo = "no image";
            $bank->status = $x['status'];
            if (!$bank->save()) {
                Log::error('setup bank failed ' . json_encode($bank->errors));
            }

        }, $banksCsvResult);

        #ASSET CARRIER
        $carrierDataCsvFile = base_path() . "/public/src/rajaongkir_kurir.csv";
        $carrierDataResult = CsvConverter::csvToArray($carrierDataCsvFile);

        array_map(function ($x) {
            $carrier = AssetCarrier::inst();
            $carrier->logo = $x['logo'];
            $carrier->name = $x['name'];
            $carrier->code = $x['code'];
            $carrier->status = $x['status'];
            if (!$carrier->save()) {
                Log::error('setup carrier failed ' . json_encode($carrier->errors));
            }
        }, $carrierDataResult);

        #ASSET PAYMENT METHOD
        $paymentMethodData = [
            'Bank Transfer', 'Cash'
        ];

        array_map(function ($x) {
            $payment_method = AssetPaymentMethod::inst();
            $payment_method->name = $x;
            $payment_method->description = "description of " . $x;
            $payment_method->status = true;
            if (!$payment_method->save()) {
                Log::error('setup payment method failed ' . json_encode($payment_method->errors));
            }
        }, $paymentMethodData);

        #ASSET WEIGHT UNIT
        $weightUnits = [
            ['gr', 'gram'],
            ['kg', 'kilogram']
        ];

        array_map(function ($x) {
            $weightUnit = AssetWeightUnit::inst();
            $weightUnit->code = str_replace(" ", "", $x[0]);
            $weightUnit->name = str_replace(" ", "", $x[1]);
            $weightUnit->status = true;
            if (!$weightUnit->save()) {
                Log::error('setup weight unit failed' . json_encode($weightUnit->errors));
            }
        }, $weightUnits);
    }
}