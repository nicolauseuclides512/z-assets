<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => env('APP_VERSION', 'v1')], function () {

    Route::get('/', function () {
        return 'Zuragan Asset API ' . env('APP_VERSION') . ' [' . env('APP_ENV') . ']';
    });

    /** deprecated > replace ongkir prefix */
    Route::group(['prefix' => 'pub'], function () {

        Route::get('/pi', function () {
            phpinfo();
        });


        Route::get('search-cities', 'AssetRegionController@searchCities');
        Route::get('districts', 'AssetDistrictController@index');
        Route::get('carriers/list', 'AssetCarrierController@list');

        Route::get('countries/nested_list', 'AssetCountryController@getNestedList');
        Route::get('countries/list', 'AssetCountryController@list');

        Route::get('provinces/list', 'AssetProvinceController@list');

        Route::get('districts/list', 'AssetDistrictController@list');

        Route::get('regions/list', 'AssetRegionController@list');
    });

    Route::group(['prefix' => 'ongkir'], function () {

        Route::get('carriers/old-list', 'AssetCarrierController@ongkirOldList');
        Route::get('carriers/list', 'AssetCarrierController@ongkirList');
        Route::get('carriers/logo/{code}', 'AssetCarrierController@ongkirLogoByCode');

        Route::get('countries/nested-list', 'AssetCountryController@ongkirNestedList');
        Route::get('countries/list', 'AssetCountryController@ongkirList');
        Route::get('countries/areas', 'AssetCountryController@ongkirAreaById');

        Route::get('provinces/list', 'AssetProvinceController@ongkirList');

        Route::get('districts/list', 'AssetDistrictController@ongkirList');
        Route::get('districts/{id}', 'AssetDistrictController@ongkirDetail');

        Route::get('search-cities', 'AssetRegionController@searchCities');
        Route::get('regions/list', 'AssetRegionController@ongkirList');
        Route::get('regions/{id}', 'AssetRegionController@ongkirDetail');

        Route::get('lion-parcels/cost-route', 'AssetLionParcelController@ongkirCostRoute');
    });

    Route::group(['middleware' => ['authToken:api']], function () {

        Route::get('/ping', function () {
            return 'pong.';
        });

        Route::get('countries/nested_list', 'AssetCountryController@getNestedList');
        Route::get('countries/list', 'AssetCountryController@list');
        Route::get('countries/areas', 'AssetCountryController@getAreaById');
        Route::resource('countries', 'AssetCountryController');

        Route::get('provinces/list', 'AssetProvinceController@list');
        Route::resource('provinces', 'AssetProvinceController');
        Route::get('provinces/countries/{id}', 'AssetProvinceController@getByCountry');

        Route::get('districts/list', 'AssetDistrictController@list');
        Route::resource('districts', 'AssetDistrictController');
        Route::get('districts/provinces/{id}', 'AssetDistrictController@getByProvince');

        Route::group(['prefix' => 'regions'], function () {
            Route::get('/list', 'AssetRegionController@list');
            Route::get('/districts/{id}', 'AssetRegionController@getByDistrict');
            Route::get('/search-cities', 'AssetRegionController@searchCities');
        });
        Route::resource('regions', 'AssetRegionController');

        Route::get('timezones/list', 'AssetTimezoneController@list');
        Route::resource('timezones', 'AssetTimezoneController');

        Route::get('currencies/list', 'AssetCurrencyController@list');
        Route::resource('currencies', 'AssetCurrencyController');

        Route::get('banks/list', 'AssetBankController@list');
        Route::resource('banks', 'AssetBankController');
        Route::get('banks/name/{name}', 'AssetBankController@getByName');


        Route::get('carriers/list', 'AssetCarrierController@list');
        Route::get('carriers/code/{code}', 'AssetCarrierController@getByCode');
        Route::resource('carriers', 'AssetCarrierController');

        Route::get('payment_methods/list', 'AssetPaymentMethodController@list');
        Route::resource('payment_methods', 'AssetPaymentMethodController');

        Route::get('weight_units/list', 'AssetWeightUnitController@list');
        Route::resource('weight_units', 'AssetWeightUnitController');
        Route::get('weight_units/code/{code}', 'AssetWeightUnitController@getByCode');

        Route::get('languages/list', 'AssetLanguageController@list');
        Route::resource('languages', 'AssetLanguageController');

    });
});

