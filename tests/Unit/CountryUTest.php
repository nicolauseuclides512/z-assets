<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetCountry;

class CountryUTest extends \TestCase
{

    public function test_if_code_value_is_empty_it_can_be_created()
    {
        #prepare data
        $country = factory(AssetCountry::class)->make();
        $country->code = '';
        $country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($country, 'code'), true);
    }

    public function test_if_code_value_is_null_it_can_be_created()
    {
        #prepare data
        $country = factory(AssetCountry::class)->make();
        $country->code = null;
        $country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($country, 'code'), true);
    }

    public function test_if_code_value_is_greater_than_max_characters_it_must_be_rejected()
    {
        #prepare data
        $country = factory(AssetCountry::class)->make();
        $country->code = 'AAAAAA';
        $country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($country, 'code'), false);
    }

    public function test_if_status_value_is_empty_it_must_be_rejected()
    {
        $country = factory(AssetCountry::class)->make();
        $country->status = '';
        $country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($country, 'status'), false);
    }

    public function test_if_status_value_is_null_it_must_be_rejected()
    {
        $country = factory(AssetCountry::class)->make();
        $country->status = null;
        $country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($country, 'status'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $country_statuses = array(0, 1);

        foreach ($country_statuses as $status) {
            $country = factory(AssetCountry::class)->make();
            $country->status = $status;
            $country->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($country, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $country = factory(AssetCountry::class)->make();
        $country->status = 'status';
        $country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($country, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $country_statuses = array(-1, 2, 3, 4);

        foreach ($country_statuses as $status) {
            $country = factory(AssetCountry::class)->make();
            $country->status = $status;
            $country->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($country, 'status'), false);
        }
    }

    public function test_if_required_name_value_is_empty_it_must_be_rejected()
    {
        $country = factory(AssetCountry::class)->make();
        $country->name = '';
        $country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($country, 'name'), false);
    }

    public function test_if_required_name_value_is_null_it_must_be_rejected()
    {
        $country = factory(AssetCountry::class)->make();
        $country->name = null;
        $country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($country, 'name'), false);
    }

    public function test_if_code_duplicated_it_must_be_rejected()
    {
        #prepare data
        $country = factory(AssetCountry::class)->make();
        $country->code = 'USA';
        $country->save();

        $existing_country = factory(AssetCountry::class)->make();
        $existing_country->code = 'USA';
        $existing_country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($existing_country, 'code'), false);
    }

    public function test_it_saves_valid_country_it_can_be_created()
    {
        $country = factory(AssetCountry::class)->make();
        $this->assertEquals($country->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        $countries = factory(AssetCountry::class, 5)->make();

        $this->assertEquals(count($countries), 5);
    }

    public function test_if_search_data_by_key_its_must_be_founded()
    {
        //assumption
        factory(AssetCountry::class, 5)->make();

        $countryID = factory(AssetCountry::class)->make();
        $countryID->code = 'ID';
        $countryID->name = 'Indonesia';
        $countryID->save();

        $countryIN = factory(AssetCountry::class)->make();
        $countryIN->code = 'IN';
        $countryIN->name = 'India';
        $countryIN->save();

        //call actual method
        $totalCountryIsFounded = AssetCountry::inst()
            ->filter('', 'ind')->count();

        //checking code
        $this->assertEquals($totalCountryIsFounded, 2);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetCountry::class, 5)->make();

        $countryID = factory(AssetCountry::class)->make();
        $countryID->code = 'ID';
        $countryID->name = 'Indonesia';
        $countryID->status = true;
        $countryID->save();

        $countryIN = factory(AssetCountry::class)->make();
        $countryIN->code = 'IN';
        $countryIN->name = 'India';
        $countryIN->status = false;
        $countryIN->save();

        $countryIN = factory(AssetCountry::class)->make();
        $countryIN->code = 'US';
        $countryIN->name = 'America';
        $countryIN->status = false;
        $countryIN->save();

        //call actual method
        $existingCountries = AssetCountry::inst()
            ->filter(AssetCountry::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingCountries->count(), 1);
        $this->assertEquals($existingCountries->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetCountry::class, 5)->make();

        $countryID = factory(AssetCountry::class)->make();
        $countryID->code = 'ID';
        $countryID->name = 'Indonesia';
        $countryID->status = true;
        $countryID->save();

        $countryIN = factory(AssetCountry::class)->make();
        $countryIN->code = 'IN';
        $countryIN->name = 'India';
        $countryIN->status = true;
        $countryIN->save();

        $countryIN = factory(AssetCountry::class)->make();
        $countryIN->code = 'US';
        $countryIN->name = 'America';
        $countryIN->status = false;
        $countryIN->save();

        //call actual method
        $existingCountries = AssetCountry::inst()
            ->filter(AssetCountry::STATUS_ACTIVE, 'ind');

        //checking code
        $this->assertEquals($existingCountries->count(), 2);
        $this->assertEquals($existingCountries->first()->status, true);
    }



//    public function test_if_fetch_nested_data_its_must_nested()
//    {
//        //assumption
//        factory(AssetCountry::class, 5)->make();
//
//        $countryID = factory(AssetCountry::class)->make();
//        $countryID->code = 'ID';
//        $countryID->name = 'Indonesia';
//        $countryID->status = true;
//        $countryID->save();
//
//        $countryIN = factory(AssetCountry::class)->make();
//        $countryIN->code = 'IN';
//        $countryIN->name = 'India';
//        $countryIN->status = false;
//        $countryIN->save();
//
//        $countryIN = factory(AssetCountry::class)->make();
//        $countryIN->code = 'US';
//        $countryIN->name = 'America';
//        $countryIN->status = false;
//        $countryIN->save();
//
//        //call actual method
//        $existingCountries = AssetCountry::inst()
//            ->filter(AssetCountry::STATUS_ACTIVE, '');
//
//        //checking code
//        $this->assertEquals($existingCountries->count(), 1);
//        $this->assertEquals($existingCountries->first()->status, true);
//    }
//
//    public function test_if_fetch_by_area_id_its_must_be_show_area()
//    {
//        //assumption
//        factory(AssetCountry::class, 5)->make();
//
//        $countryID = factory(AssetCountry::class)->make();
//        $countryID->code = 'ID';
//        $countryID->name = 'Indonesia';
//        $countryID->status = true;
//        $countryID->save();
//
//        $countryIN = factory(AssetCountry::class)->make();
//        $countryIN->code = 'IN';
//        $countryIN->name = 'India';
//        $countryIN->status = false;
//        $countryIN->save();
//
//        $countryIN = factory(AssetCountry::class)->make();
//        $countryIN->code = 'US';
//        $countryIN->name = 'America';
//        $countryIN->status = false;
//        $countryIN->save();
//
//        //call actual method
//        $existingCountries = AssetCountry::inst()
//            ->filter(AssetCountry::STATUS_ACTIVE, '');
//
//        //checking code
//        $this->assertEquals($existingCountries->count(), 1);
//        $this->assertEquals($existingCountries->first()->status, true);
//    }
}
