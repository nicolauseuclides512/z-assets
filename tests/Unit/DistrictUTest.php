<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetCountry;
use App\Models\AssetDistrict;
use App\Models\AssetProvince;

class DistrictUTest extends \TestCase
{

    private $country;

    private $province;

    protected function setUp()
    {
        parent::setUp();

        $this->country = factory(AssetCountry::class)->create();
        $this->province = factory(AssetProvince::class)->make();
        $this->province->country_id = $this->country->id;
        $this->province->save();
    }

    public function test_if_required_province_id_field_is_empty_it_must_be_rejected()
    {
        #prepare data
        //province
        $district = factory(AssetDistrict::class)->make();
        $district->province_id = "";
        $district->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($district, 'province_id'), false);
    }

    public function test_if_required_province_id_field_is_null_it_must_be_rejected()
    {
        #assumption

        //province
        $district = factory(AssetDistrict::class)->make();
        $district->province_id = null;
        $district->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($district, 'province_id'), false);
    }

    public function test_if_province_id_value_does_not_exist_in_country_it_must_be_rejected()
    {
        $district = factory(AssetDistrict::class)->make();
        $district->province_id = 20; //does not exist in country record
        $district->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($district, 'province_id'), false);
    }

    public function test_if_required_name_is_empty_it_must_be_rejected()
    {
        #prepare data

        $district = factory(AssetDistrict::class)->make();
        $district->province_id = $this->province->id;
        $district->name = "";
        $district->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($district, 'name'), false);
    }

    public function test_if_required_name_is_null_it_must_be_rejected()
    {
        #prepare data
        $district = factory(AssetDistrict::class)->make();
        $district->province_id = $this->province->id;
        $district->name = null;
        $district->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($district, 'name'), false);
    }

    public function test_if_status_value_is_null_it_must_be_rejected()
    {
        $district = factory(AssetDistrict::class)->make();
        $district->province_id = $this->province->id;
        $district->status = null;
        $district->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($district, 'status'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $district_statuses = array(0, 1);

        foreach ($district_statuses as $status) {
            $district = factory(AssetDistrict::class)->make();
            $district->province_id = $this->province->id;
            $district->status = $status;
            $district->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($district, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $district = factory(AssetDistrict::class)->make();
        $district->province_id = $this->province->id;
        $district->status = 'status';
        $district->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($district, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $statuses = array(-1, 2, 3, 4);

        foreach ($statuses as $status) {
            $district = factory(AssetDistrict::class)->make();
            $district->province_id = $this->province->id;
            $district->status = $status;
            $district->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($district, 'status'), false);
        }
    }

    public function test_if_code_duplicated_it_can_be_created()
    {
        #prepare data
        $district1 = factory(AssetDistrict::class)->make();
        $district1->province_id = $this->province->id;
        $district1->name = 'YOGYAKARTA';
        $district1->save();

        $district2 = factory(AssetDistrict::class)->make();
        $district2->province_id = $this->province->id;
        $district2->name = 'YOGYAKARTA';
        $district2->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($district2, 'name'), true);
    }

    public function test_it_saves_invalid_type_it_must_be_rejected()
    {
        $validTypes = ['invalid_type'];

        array_map(function ($type) {
            $district = factory(AssetDistrict::class)->make();
            $district->province_id = $this->province->id;
            $district->type = $type;
            $this->assertEquals($district->save(), false);
        }, $validTypes);

    }

    public function test_it_saves_valid_type_it_can_be_created()
    {
        $validTypes = ['city'];

        array_map(function ($type) {
            $district = factory(AssetDistrict::class)->make();
            $district->province_id = $this->province->id;
            $district->type = $type;
            $this->assertEquals($district->save(), true);
        }, $validTypes);

    }

    public function test_it_saves_valid_data_it_can_be_created()
    {
        $district = factory(AssetDistrict::class)->make();
        $district->province_id = $this->province->id;

        $this->assertEquals($district->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        for ($i = 0; $i < 5; $i++) {
            $district = factory(AssetDistrict::class)->make();
            $district->province_id = $this->province->id;
            $district->save();
        }

        $this->assertEquals(count(AssetDistrict::all()), 5);
    }

    public function test_if_search_data_by_key_its_must_be_founded()
    {
        //assumption
        for ($i = 0; $i < 5; $i++) {
            $district = factory(AssetDistrict::class)->make();
            $district->province_id = $this->province->id;
            $district->save();
        }

        $district = factory(AssetDistrict::class)->make();
        $district->province_id = $this->province->id;
        $district->name = 'Tembarak';
        $district->save();

        $district = factory(AssetDistrict::class)->make();
        $district->province_id = $this->province->id;
        $district->name = 'Temanggung';
        $district->save();

        //call actual method
        $totalDistrictFound = AssetDistrict::inst()
            ->filter('', 'tem')->count();

        //checking code
        $this->assertEquals($totalDistrictFound, 2);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption

        for ($i = 5; $i < 5; $i++) {
            $district = factory(AssetDistrict::class)->make();
            $district->province_id = $this->province->id;
            $district->save();
        }


        $districtJT = factory(AssetDistrict::class)->make();
        $districtJT->province_id = $this->province->id;
        $districtJT->name = 'TEGAL';
        $districtJT->status = true;
        $districtJT->save();

        $districtJB = factory(AssetDistrict::class)->make();
        $districtJB->province_id = $this->province->id;
        $districtJB->name = 'TEMANGGUNG';
        $districtJB->status = false;
        $districtJB->save();

        $districtYOG = factory(AssetDistrict::class)->make();
        $districtYOG->province_id = $this->province->id;
        $districtYOG->name = 'YOGYAKARTA';
        $districtYOG->status = false;
        $districtYOG->save();

        //call actual method
        $existingProvinces = AssetDistrict::inst()
            ->filter(AssetDistrict::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingProvinces->count(), 1);
        $this->assertEquals($existingProvinces->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_founded()
    {
        //assumption
        for ($i = 5; $i < 5; $i++) {
            $district = factory(AssetDistrict::class)->make();
            $district->province_id = $this->province->id;
            $district->save();
        }


        $districtJT = factory(AssetDistrict::class)->make();
        $districtJT->province_id = $this->province->id;
        $districtJT->name = 'TEGAL';
        $districtJT->status = true;
        $districtJT->save();

        $districtJB = factory(AssetDistrict::class)->make();
        $districtJB->province_id = $this->province->id;
        $districtJB->name = 'TEMANGGUNG';
        $districtJB->status = true;
        $districtJB->save();

        $districtYOG = factory(AssetDistrict::class)->make();
        $districtYOG->province_id = $this->province->id;
        $districtYOG->name = 'SEMARANG';
        $districtYOG->status = false;
        $districtYOG->save();

        //call actual method
        $existingProvinces = AssetDistrict::inst()
            ->filter(AssetDistrict::STATUS_ACTIVE, 'te');

        //checking code
        $this->assertEquals($existingProvinces->count(), 2);
        $this->assertEquals($existingProvinces->first()->status, true);
    }

}
