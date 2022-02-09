<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetCountry;
use App\Models\AssetProvince;

class ProvinceUTest extends \TestCase
{

    private $country;

    protected function setUp()
    {
        parent::setUp();
        $this->country = factory(AssetCountry::class)->create();
    }

    public function test_if_required_country_id_field_is_empty_it_must_be_rejected()
    {
        #prepare data
        //province
        $province = factory(AssetProvince::class)->make();
        $province->country_id = "";
        $province->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($province, 'country_id'), false);
    }

    public function test_if_required_country_id_field_is_null_it_must_be_rejected()
    {
        #assumption

        //province
        $province = factory(AssetProvince::class)->make();
        $province->country_id = null;
        $province->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($province, 'country_id'), false);
    }

    public function test_if_country_id_value_does_not_exist_in_country_it_must_be_rejected()
    {
        $province = factory(AssetProvince::class)->make();
        $province->country_id = 20; //does not exist in country record
        $province->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($province, 'country_id'), false);
    }

    public function test_if_required_name_is_empty_it_must_be_rejected()
    {
        #prepare data


        $province = factory(AssetProvince::class)->make();
        $province->country_id = $this->country->id;
        $province->name = "";
        $province->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($province, 'name'), false);
    }

    public function test_if_required_name_is_null_it_must_be_rejected()
    {
        #prepare data

        $province = factory(AssetProvince::class)->make();
        $province->country_id = $this->country->id;
        $province->name = null;
        $province->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($province, 'name'), false);
    }

    public function test_if_status_value_is_null_it_must_be_rejected()
    {

        $province = factory(AssetProvince::class)->make();
        $province->country_id = $this->country->id;
        $province->status = null;
        $province->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($province, 'status'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {

        #prepare data
        $province_statuses = array(0, 1);

        foreach ($province_statuses as $status) {
            $province = factory(AssetProvince::class)->make();
            $province->country_id = $this->country->id;
            $province->status = $status;
            $province->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($province, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {

        $province = factory(AssetProvince::class)->make();
        $province->country_id = $this->country->id;
        $province->status = 'status';
        $province->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($province, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data

        $statuses = array(-1, 2, 3, 4);

        foreach ($statuses as $status) {
            $province = factory(AssetProvince::class)->make();
            $province->country_id = $this->country->id;
            $province->status = $status;
            $province->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($province, 'status'), false);
        }
    }

    public function test_if_code_duplicated_it_must_be_rejected()
    {
        #prepare data

        $province1 = factory(AssetProvince::class)->make();
        $province1->country_id = $this->country->id;
        $province1->name = 'DI. YOGYAKARTA';
        $province1->save();

        $province2 = factory(AssetProvince::class)->make();
        $province2->country_id = $this->country->id;
        $province2->name = 'DI. YOGYAKARTA';
        $province2->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($province2, 'name'), false);
    }

    public function test_it_saves_valid_data_it_can_be_created()
    {

        $province = factory(AssetProvince::class)->make();
        $province->country_id = $this->country->id;

        $this->assertEquals($province->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {

        for ($i = 0; $i < 5; $i++) {
            $province = factory(AssetProvince::class)->make();
            $province->country_id = $this->country->id;
            $province->save();
        }

        $this->assertEquals(count(AssetProvince::all()), 5);
    }

    public function test_if_search_data_by_key_its_must_be_founded()
    {
        //assumption

        for ($i = 0; $i < 5; $i++) {
            $province = factory(AssetProvince::class)->make();
            $province->country_id = $this->country->id;
            $province->save();
        }

        $province = factory(AssetProvince::class)->make();
        $province->country_id = $this->country->id;
        $province->name = 'JAWA BARAT';
        $province->save();

        $province = factory(AssetProvince::class)->make();
        $province->country_id = $this->country->id;
        $province->name = 'JAWA TENGAH';
        $province->save();

        //call actual method
        $totalProvinceIsFounded = AssetProvince::inst()
            ->filter('', 'jawa')->count();

        //checking code
        $this->assertEquals($totalProvinceIsFounded, 2);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption


        for ($i = 5; $i < 5; $i++) {
            $province = factory(AssetProvince::class)->make();
            $province->country_id = $this->country->id;
            $province->save();
        }


        $provinceJT = factory(AssetProvince::class)->make();
        $provinceJT->country_id = $this->country->id;
        $provinceJT->name = 'JAWA TENGAH';
        $provinceJT->status = true;
        $provinceJT->save();

        $provinceJB = factory(AssetProvince::class)->make();
        $provinceJB->country_id = $this->country->id;
        $provinceJB->name = 'JAWA BARAT';
        $provinceJB->status = false;
        $provinceJB->save();

        $provinceYOG = factory(AssetProvince::class)->make();
        $provinceYOG->country_id = $this->country->id;
        $provinceYOG->name = 'YOGYAKARTA';
        $provinceYOG->status = false;
        $provinceYOG->save();

        //call actual method
        $existingProvinces = AssetProvince::inst()
            ->filter(AssetProvince::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingProvinces->count(), 1);
        $this->assertEquals($existingProvinces->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_founded()
    {
        //assumption


        for ($i = 5; $i < 5; $i++) {
            $province = factory(AssetProvince::class)->make();
            $province->country_id = $this->country->id;
            $province->save();
        }


        $provinceJT = factory(AssetProvince::class)->make();
        $provinceJT->country_id = $this->country->id;
        $provinceJT->name = 'JAWA TENGAH';
        $provinceJT->status = true;
        $provinceJT->save();

        $provinceJB = factory(AssetProvince::class)->make();
        $provinceJB->country_id = $this->country->id;
        $provinceJB->name = 'JAWA BARAT';
        $provinceJB->status = true;
        $provinceJB->save();

        $provinceYOG = factory(AssetProvince::class)->make();
        $provinceYOG->country_id = $this->country->id;
        $provinceYOG->name = 'JAWA TIMUR';
        $provinceYOG->status = false;
        $provinceYOG->save();

        //call actual method
        $existingProvinces = AssetProvince::inst()
            ->filter(AssetProvince::STATUS_ACTIVE, 'jawa');

        //checking code
        $this->assertEquals($existingProvinces->count(), 2);
        $this->assertEquals($existingProvinces->first()->status, true);
    }

}
