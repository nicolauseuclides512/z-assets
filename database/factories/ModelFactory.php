<?php

use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(\App\Models\AssetCountry::class, function (Faker $faker) {
    return [
        'code' => $faker->countryCode,
        'name' => $faker->country,
        'status' => true
    ];
});

$factory->define(App\Models\AssetProvince::class, function (Faker $faker) {
    return [
        'country_id' => 1,
        'name' => $faker->city,
        'status' => 1
    ];
});

$factory->define(App\Models\AssetDistrict::class, function (Faker $faker) {
    return [
        'province_id' => 1,
        'name' => $faker->city,
        'type' => 'city',
        'zip' => $faker->postcode,
        'status' => 1
    ];
});

$factory->define(App\Models\AssetRegion::class, function (Faker $faker) {
    return [
        'district_id' => 1,
        'name' => $faker->city,
        'type' => 'subdistrict',
        'zip' => $faker->postcode,
        'status' => 1
    ];
});

$factory->define(\App\Models\AssetBank::class, function (Faker $faker) {
    return [
        'name' => 'bank ' . $faker->colorName,
        'logo' => $faker->imageUrl(),
        'status' => true
    ];
});

$factory->define(\App\Models\AssetCarrier::class, function (Faker $faker) {
    return [
        'code' => $faker->countryCode,
        'name' => 'carrier ' . $faker->colorName,
        'logo' => $faker->imageUrl(),
        'status' => true
    ];
});

$factory->define(App\Models\AssetCurrency::class, function (Faker $faker) {
    return [
        'code' => $faker->currencyCode,
        'symbol' => "$",
        'name' => "Dollar",
        'iso_2' => '',
        'iso_3' => '',
        'status' => 1
    ];
});

$factory->define(App\Models\AssetLanguage::class, function (Faker $faker) {
    return [
        'code' => $faker->languageCode,
        'name' => $faker->colorName,
        'status' => 1
    ];
});


$factory->define(App\Models\AssetPaymentMethod::class, function (Faker $faker) {
    return [
        'name' => $faker->domainName,
        'description' => $faker->text,
        'status' => 1
    ];
});

$factory->define(App\Models\AssetTimezone::class, function (Faker $faker) {
    return [
        'name' => $faker->timezone,
        'zone' => 0,
        'status' => 1
    ];
});

$factory->define(App\Models\AssetWeightUnit::class, function (Faker $faker) {
    return [
        'name' => 'gram',
        'code' => 'gr' . random_int(0, 999),
        'status' => 1
    ];
});
