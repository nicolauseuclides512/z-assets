<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;

use App\Models\AssetTimezone;

class TimezoneUTest extends \TestCase
{

    public function test_if_status_value_is_empty_it_must_be_rejected()
    {
        $timezone = factory(AssetTimezone::class)->make();
        $timezone->status = '';
        $timezone->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($timezone, 'status'), false);
    }

    public function test_if_status_value_is_null_it_must_be_rejected()
    {
        $timezone = factory(AssetTimezone::class)->make();
        $timezone->status = null;
        $timezone->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($timezone, 'status'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $timezone_statuses = array(0, 1);

        foreach ($timezone_statuses as $status) {
            $timezone = factory(AssetTimezone::class)->make();
            $timezone->status = $status;
            $timezone->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($timezone, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $timezone = factory(AssetTimezone::class)->make();
        $timezone->status = 'status';
        $timezone->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($timezone, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $timezone_statuses = [-1, 2, 3, 4];

        foreach ($timezone_statuses as $status) {
            $timezone = factory(AssetTimezone::class)->make();
            $timezone->status = $status;
            $timezone->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($timezone, 'status'), false);
        }
    }

    public function test_if_required_name_value_is_empty_it_must_be_rejected()
    {
        $timezone = factory(AssetTimezone::class)->make();
        $timezone->name = '';
        $timezone->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($timezone, 'name'), false);
    }

    public function test_if_required_name_value_is_null_it_must_be_rejected()
    {
        $timezone = factory(AssetTimezone::class)->make();
        $timezone->name = null;
        $timezone->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($timezone, 'name'), false);
    }

    public function test_if_code_duplicated_it_must_be_rejected()
    {
        #prepare data
        $timezone1 = factory(AssetTimezone::class)->make();
        $timezone1->name = 'UTC';
        $timezone1->zone = 0;
        $timezone1->save();

        $timezone2 = factory(AssetTimezone::class)->make();
        $timezone2->name = 'ICT';
        $timezone2->zone = 7;
        $timezone2->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($timezone2, 'name'), false);
    }

    public function test_it_saves_valid_country_it_can_be_created()
    {
        $timezone = factory(AssetTimezone::class)->make();
        $this->assertEquals($timezone->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        $countries = factory(AssetTimezone::class, 5)->make();

        $this->assertEquals(count($countries), 5);
    }

    public function test_if_search_data_by_key_its_must_be_founded()
    {
        //assumption
        $timezone1 = factory(AssetTimezone::class)->make();
        $timezone1->name = 'UTC';
        $timezone1->zone = 0;
        $timezone1->save();

        $timezone2 = factory(AssetTimezone::class)->make();
        $timezone2->name = 'ICT';
        $timezone2->zone = 7;
        $timezone2->save();

        //call actual method
        $totalCountryIsFounded = AssetTimezone::inst()
            ->filter('', '')->count();

        //checking code
        $this->assertEquals($totalCountryIsFounded, 2);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetTimezone::class, 5)->make();

        $timezoneID = factory(AssetTimezone::class)->make();
        $timezoneID->name = 'BANK MANDIRI';
        $timezoneID->status = true;
        $timezoneID->save();

        $timezoneIN = factory(AssetTimezone::class)->make();
        $timezoneIN->name = 'BANK CENTRAL ASIA';
        $timezoneIN->status = false;
        $timezoneIN->save();

        $timezoneIN = factory(AssetTimezone::class)->make();
        $timezoneIN->name = 'BNI';
        $timezoneIN->status = false;
        $timezoneIN->save();

        //call actual method
        $existingCountries = AssetTimezone::inst()
            ->filter(AssetTimezone::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingCountries->count(), 1);
        $this->assertEquals($existingCountries->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetTimezone::class, 5)->make();

        $timezoneID = factory(AssetTimezone::class)->make();
        $timezoneID->name = 'BANK MANDIRI';
        $timezoneID->status = true;
        $timezoneID->save();

        $timezoneIN = factory(AssetTimezone::class)->make();
        $timezoneIN->name = 'BANK CENTRAL ASIA';
        $timezoneIN->status = true;
        $timezoneIN->save();

        $timezoneIN = factory(AssetTimezone::class)->make();
        $timezoneIN->name = 'BNI';
        $timezoneIN->status = false;
        $timezoneIN->save();

        //call actual method
        $existingCountries = AssetTimezone::inst()
            ->filter(AssetTimezone::STATUS_ACTIVE, 'bank');

        //checking code
        $this->assertEquals($existingCountries->count(), 2);
        $this->assertEquals($existingCountries->first()->status, true);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_create_a_data()
    {
        $timezoneObj = factory(AssetTimezone::class)->make();

        $storedBank = AssetTimezone::inst()->storeExec($timezoneObj);

        $this->assertEquals($storedBank->name, $timezoneObj->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_update_the_data()
    {
        $timezoneObj = factory(AssetTimezone::class)->create();

        $newBank = factory(AssetTimezone::class)->make();

        $updatedBank = AssetTimezone::inst()->updateExec($newBank, $timezoneObj->id);

        $this->assertEquals($updatedBank->name, $newBank->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_the_data()
    {
        $timezoneObj = factory(AssetTimezone::class)->create();

        $deletedBank = AssetTimezone::inst()->destroyExec($timezoneObj->id);

        $this->assertTrue($deletedBank);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_some_data()
    {
        $timezoneObjects = factory(AssetTimezone::class, 3)->create();

        $ids = "";

        foreach ($timezoneObjects->toArray() as $k => $v) {
            $ids .= count($timezoneObjects->toArray()) - 1 !== $k
                ? $v['id'] . ","
                : $v['id'];
        }

        $deletedBank = AssetTimezone::inst()->destroySomeExec($ids);

        $this->assertTrue($deletedBank);
    }

//    /**
//     */
//    public function test_if_data_does_not_exist_it_can_not_delete_some_data()
//    {
//        try {
//            AssetTimezone::inst()->destroySomeExec("123,34");
//        } catch (\Exception $e) {
//
//        }
//
//    }

}
