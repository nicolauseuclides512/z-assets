<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetCarrier;

class CarrierUTest extends \TestCase
{
    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $carrier_statuses = array(0, 1);

        foreach ($carrier_statuses as $status) {
            $carrier = factory(AssetCarrier::class)->make();
            $carrier->status = $status;
            $carrier->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($carrier, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $carrier = factory(AssetCarrier::class)->make();
        $carrier->status = 'status';
        $carrier->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($carrier, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $carrier_statuses = array(-1, 2, 3, 4);

        foreach ($carrier_statuses as $status) {
            $carrier = factory(AssetCarrier::class)->make();
            $carrier->status = $status;
            $carrier->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($carrier, 'status'), false);
        }
    }

    public function test_if_required_name_value_is_empty_it_must_be_rejected()
    {
        $carrier = factory(AssetCarrier::class)->make();
        $carrier->name = '';
        $carrier->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($carrier, 'name'), false);
    }

    public function test_if_required_name_value_is_null_it_must_be_rejected()
    {
        $carrier = factory(AssetCarrier::class)->make();
        $carrier->name = null;
        $carrier->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($carrier, 'name'), false);
    }

    public function test_if_code_duplicated_it_must_be_rejected()
    {
        #prepare data
        $carrier1 = factory(AssetCarrier::class)->make();
        $carrier1->code = 'JNE';
        $carrier1->save();

        $carrier2 = factory(AssetCarrier::class)->make();
        $carrier2->code = 'JNE';
        $carrier2->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($carrier2, 'code'), false);
    }

    public function test_it_saves_valid_data_it_can_be_created()
    {
        $carrier = factory(AssetCarrier::class)->make();
        $this->assertEquals($carrier->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        $countries = factory(AssetCarrier::class, 5)->make();

        $this->assertEquals(count($countries), 5);
    }

    public function test_if_search_data_by_key_name_its_must_be_founded()
    {
        //assumption
        factory(AssetCarrier::class, 5)->make();

        $carrierID = factory(AssetCarrier::class)->make();
        $carrierID->code = 'JNE';
        $carrierID->name = 'Jalur Nugraha Ekakurir';
        $carrierID->save();

        $carrierIN = factory(AssetCarrier::class)->make();
        $carrierIN->code = 'JNT';
        $carrierIN->name = 'JNT Express';
        $carrierIN->save();

        //call actual method
        $totalDataFound = AssetCarrier::inst()
            ->filter('', 'jalur')
            ->count();

        //checking code
        $this->assertEquals($totalDataFound, 1);
    }

    public function test_if_search_data_by_key_code_its_must_be_founded()
    {
        //assumption

        $carrier1 = factory(AssetCarrier::class)->make();
        $carrier1->code = 'JNE';
        $carrier1->name = 'Jalur Nugraha Ekakurir';
        $carrier1->save();

        $carrier2 = factory(AssetCarrier::class)->make();
        $carrier2->code = 'JNT';
        $carrier2->name = 'JNT Express';
        $carrier2->save();

        //call actual method
        $totalCountryIsFounded = AssetCarrier::inst()
            ->filter('', 'jn')->count();

        //checking code
        $this->assertEquals($totalCountryIsFounded, 2);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetCarrier::class, 5)->make();

        $carrier1 = factory(AssetCarrier::class)->make();
        $carrier1->code = 'JNE';
        $carrier1->name = 'Jalur Nugraha Ekakurir';
        $carrier1->status = true;
        $carrier1->save();

        $carrier2 = factory(AssetCarrier::class)->make();
        $carrier2->code = 'JNT';
        $carrier2->name = 'JNT Express';
        $carrier2->status = false;
        $carrier2->save();

        $carrier3 = factory(AssetCarrier::class)->make();
        $carrier3->code = 'POS';
        $carrier3->name = 'POS Indonesia';
        $carrier3->status = false;
        $carrier3->save();

        //call actual method
        $existingCarrier = AssetCarrier::inst()
            ->filter(AssetCarrier::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingCarrier->count(), 1);
        $this->assertEquals($existingCarrier->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetCarrier::class, 5)->make();

        $carrier1 = factory(AssetCarrier::class)->make();
        $carrier1->code = 'JNE';
        $carrier1->name = 'Jalur Nugraha Ekakurir';
        $carrier1->status = true;
        $carrier1->save();

        $carrier2 = factory(AssetCarrier::class)->make();
        $carrier2->code = 'JNT';
        $carrier2->name = 'JNT Express';
        $carrier2->status = true;
        $carrier2->save();

        $carrier3 = factory(AssetCarrier::class)->make();
        $carrier3->code = 'POS';
        $carrier3->name = 'POS Indonesia';
        $carrier3->status = false;
        $carrier3->save();

        //call actual method
        $existingCountries = AssetCarrier::inst()
            ->filter(AssetCarrier::STATUS_ACTIVE, 'jn');

        //checking code
        $this->assertEquals($existingCountries->count(), 2);
        $this->assertEquals($existingCountries->first()->status, true);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_create_a_data()
    {
        $carrierObj = factory(AssetCarrier::class)->make();

        $storedBank = AssetCarrier::inst()->storeExec($carrierObj);

        $this->assertEquals($storedBank->name, $carrierObj->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_update_the_data()
    {
        $carrierObj = factory(AssetCarrier::class)->create();

        $newBank = factory(AssetCarrier::class)->make();

        $updatedBank = AssetCarrier::inst()->updateExec($newBank, $carrierObj->id);

        $this->assertEquals($updatedBank->name, $newBank->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_the_data()
    {
        $carrierObj = factory(AssetCarrier::class)->create();

        $deletedBank = AssetCarrier::inst()->destroyExec($carrierObj->id);

        $this->assertTrue($deletedBank);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_some_data()
    {
        $carrierObjects = factory(AssetCarrier::class, 3)->create();

        $ids = "";

        foreach ($carrierObjects->toArray() as $k => $v) {
            $ids .= count($carrierObjects->toArray()) - 1 !== $k
                ? $v['id'] . ","
                : $v['id'];
        }

        $deletedBank = AssetCarrier::inst()->destroySomeExec($ids);

        $this->assertTrue($deletedBank);
    }

//    /**
//     */
//    public function test_if_data_does_not_exist_it_can_not_delete_some_data()
//    {
//        try {
//            AssetCarrier::inst()->destroySomeExec("123,34");
//        } catch (\Exception $e) {
//
//        }
//
//    }

}
