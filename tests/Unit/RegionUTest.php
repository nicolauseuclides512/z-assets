<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetCountry;
use App\Models\AssetDistrict;
use App\Models\AssetProvince;
use App\Models\AssetRegion;

class RegionUTest extends \TestCase
{

    private $country;

    private $province;

    private $district;

    protected function setUp()
    {
        parent::setUp();

        $this->country = factory(AssetCountry::class)->create();
        $this->province = factory(AssetProvince::class)->make();
        $this->province->country_id = $this->country->id;
        $this->province->save();

        $this->district = factory(AssetDistrict::class)->make();
        $this->district->province_id = $this->province->id;
        $this->district->save();

    }

    public function test_if_required_district_id_field_is_empty_it_must_be_rejected()
    {
        #prepare data
        //district
        $region = factory(AssetRegion::class)->make();
        $region->district_id = "";
        $region->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($region, 'district_id'), false);
    }

    public function test_if_required_district_id_field_is_null_it_must_be_rejected()
    {
        #assumption

        //district
        $region = factory(AssetRegion::class)->make();
        $region->district_id = null;
        $region->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($region, 'district_id'), false);
    }

    public function test_if_district_id_value_does_not_exist_in_country_it_must_be_rejected()
    {
        $region = factory(AssetRegion::class)->make();
        $region->district_id = 20; //does not exist in country record
        $region->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($region, 'district_id'), false);
    }

    public function test_if_required_name_is_empty_it_must_be_rejected()
    {
        #prepare data
        $region = factory(AssetRegion::class)->make();
        $region->district_id = $this->district->id;
        $region->name = "";
        $region->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($region, 'name'), false);
    }

    public function test_if_required_name_is_null_it_must_be_rejected()
    {
        #prepare data
        $region = factory(AssetRegion::class)->make();
        $region->district_id = $this->district->id;
        $region->name = null;
        $region->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($region, 'name'), false);
    }

    public function test_if_status_value_is_null_it_must_be_rejected()
    {
        $region = factory(AssetRegion::class)->make();
        $region->district_id = $this->district->id;
        $region->status = null;
        $region->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($region, 'status'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $region_statuses = array(0, 1);

        foreach ($region_statuses as $status) {
            $region = factory(AssetRegion::class)->make();
            $region->district_id = $this->district->id;
            $region->status = $status;
            $region->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($region, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $region = factory(AssetRegion::class)->make();
        $region->district_id = $this->district->id;
        $region->status = 'status';
        $region->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($region, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $statuses = array(-1, 2, 3, 4);

        foreach ($statuses as $status) {
            $region = factory(AssetRegion::class)->make();
            $region->district_id = $this->district->id;
            $region->status = $status;
            $region->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($region, 'status'), false);
        }
    }

    public function test_it_saves_invalid_type_it_must_be_rejected()
    {
        $validTypes = ['invalid_type'];

        array_map(function ($type) {
            $region = factory(AssetRegion::class)->make();
            $region->district_id = $this->district->id;
            $region->type = $type;
            $this->assertEquals($region->save(), false);
        }, $validTypes);

    }

    public function test_it_saves_valid_type_it_can_be_created()
    {
        $validTypes = ['subdistrict'];

        array_map(function ($type) {
            $region = factory(AssetRegion::class)->make();
            $region->district_id = $this->district->id;
            $region->type = $type;
            $this->assertEquals($region->save(), true);
        }, $validTypes);

    }

    public function test_it_saves_valid_data_it_can_be_created()
    {
        $region = factory(AssetRegion::class)->make();
        $region->district_id = $this->district->id;

        $this->assertEquals($region->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        for ($i = 0; $i < 5; $i++) {
            $region = factory(AssetRegion::class)->make();
            $region->district_id = $this->district->id;
            $region->save();
        }

        $this->assertEquals(count(AssetRegion::all()), 5);
    }

    public function test_if_search_data_by_key_its_must_be_founded()
    {
        //assumption
        for ($i = 0; $i < 5; $i++) {
            $region = factory(AssetRegion::class)->make();
            $region->district_id = $this->district->id;
            $region->save();
        }

        $region = factory(AssetRegion::class)->make();
        $region->district_id = $this->district->id;
        $region->name = 'Tembarak';
        $region->save();

        $region = factory(AssetRegion::class)->make();
        $region->district_id = $this->district->id;
        $region->name = 'Temanggung';
        $region->save();

        //call actual method
        $totalDistrictFound = AssetRegion::inst()
            ->filter('', 'tem')->count();

        //checking code
        $this->assertEquals($totalDistrictFound, 2);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption

        for ($i = 0; $i < 5; $i++) {
            $region = factory(AssetRegion::class)->make();
            $region->district_id = $this->district->id;
            $region->save();
        }


        $regionJT = factory(AssetRegion::class)->make();
        $regionJT->district_id = $this->district->id;
        $regionJT->name = 'TEGAL';
        $regionJT->status = true;
        $regionJT->save();

        $regionJB = factory(AssetRegion::class)->make();
        $regionJB->district_id = $this->district->id;
        $regionJB->name = 'TEMANGGUNG';
        $regionJB->status = false;
        $regionJB->save();

        $regionYOG = factory(AssetRegion::class)->make();
        $regionYOG->district_id = $this->district->id;
        $regionYOG->name = 'YOGYAKARTA';
        $regionYOG->status = false;
        $regionYOG->save();

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
        for ($i = 0; $i < 5; $i++) {
            $region = factory(AssetRegion::class)->make();
            $region->district_id = $this->district->id;
            $region->save();
        }


        $regionJT = factory(AssetRegion::class)->make();
        $regionJT->district_id = $this->district->id;
        $regionJT->name = 'TEMBARAK';
        $regionJT->status = true;
        $regionJT->save();

        $regionJB = factory(AssetRegion::class)->make();
        $regionJB->district_id = $this->district->id;
        $regionJB->name = 'TEMANGGUNG';
        $regionJB->status = true;
        $regionJB->save();

        $regionYOG = factory(AssetRegion::class)->make();
        $regionYOG->district_id = $this->district->id;
        $regionYOG->name = 'SEMARANG';
        $regionYOG->status = false;
        $regionYOG->save();

        //call actual method
        $existingProvinces = AssetRegion::inst()
            ->filter(AssetRegion::STATUS_ACTIVE, 'tem');

        //checking code
        $this->assertEquals($existingProvinces->count(), 2);
        $this->assertEquals($existingProvinces->first()->status, true);
    }

}
