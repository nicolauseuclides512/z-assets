<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetBank;

class BankUTest extends \TestCase
{

    public function test_if_status_value_is_empty_it_must_be_rejected()
    {
        $bank = factory(AssetBank::class)->make();
        $bank->status = '';
        $bank->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($bank, 'status'), false);
    }

    public function test_if_status_value_is_null_it_must_be_rejected()
    {
        $bank = factory(AssetBank::class)->make();
        $bank->status = null;
        $bank->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($bank, 'status'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $bank_statuses = array(0, 1);

        foreach ($bank_statuses as $status) {
            $bank = factory(AssetBank::class)->make();
            $bank->status = $status;
            $bank->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($bank, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $bank = factory(AssetBank::class)->make();
        $bank->status = 'status';
        $bank->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($bank, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $bank_statuses = array(-1, 2, 3, 4);

        foreach ($bank_statuses as $status) {
            $bank = factory(AssetBank::class)->make();
            $bank->status = $status;
            $bank->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($bank, 'status'), false);
        }
    }

    public function test_if_required_name_value_is_empty_it_must_be_rejected()
    {
        $bank = factory(AssetBank::class)->make();
        $bank->name = '';
        $bank->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($bank, 'name'), false);
    }

    public function test_if_required_name_value_is_null_it_must_be_rejected()
    {
        $bank = factory(AssetBank::class)->make();
        $bank->name = null;
        $bank->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($bank, 'name'), false);
    }

    public function test_if_code_duplicated_it_must_be_rejected()
    {
        #prepare data
        $bank1 = factory(AssetBank::class)->make();
        $bank1->name = 'BCA';
        $bank1->save();

        $bank2 = factory(AssetBank::class)->make();
        $bank2->name = 'BCA';
        $bank2->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($bank2, 'name'), false);
    }

    public function test_it_saves_valid_country_it_can_be_created()
    {
        $bank = factory(AssetBank::class)->make();
        $this->assertEquals($bank->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        $countries = factory(AssetBank::class, 5)->make();

        $this->assertEquals(count($countries), 5);
    }

    public function test_if_search_data_by_key_its_must_be_founded()
    {
        //assumption
        factory(AssetBank::class, 5)->make();

        $bankID = factory(AssetBank::class)->make();
        $bankID->name = 'BANK CENTRAL ASIA';
        $bankID->save();

        $bankIN = factory(AssetBank::class)->make();
        $bankIN->name = 'BANK MANDIRI';
        $bankIN->save();

        //call actual method
        $totalCountryIsFounded = AssetBank::inst()
            ->filter('', 'bank')->count();

        //checking code
        $this->assertEquals($totalCountryIsFounded, 2);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetBank::class, 5)->make();

        $bankID = factory(AssetBank::class)->make();
        $bankID->name = 'BANK MANDIRI';
        $bankID->status = true;
        $bankID->save();

        $bankIN = factory(AssetBank::class)->make();
        $bankIN->name = 'BANK CENTRAL ASIA';
        $bankIN->status = false;
        $bankIN->save();

        $bankIN = factory(AssetBank::class)->make();
        $bankIN->name = 'BNI';
        $bankIN->status = false;
        $bankIN->save();

        //call actual method
        $existingCountries = AssetBank::inst()
            ->filter(AssetBank::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingCountries->count(), 1);
        $this->assertEquals($existingCountries->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetBank::class, 5)->make();

        $bankID = factory(AssetBank::class)->make();
        $bankID->name = 'BANK MANDIRI';
        $bankID->status = true;
        $bankID->save();

        $bankIN = factory(AssetBank::class)->make();
        $bankIN->name = 'BANK CENTRAL ASIA';
        $bankIN->status = true;
        $bankIN->save();

        $bankIN = factory(AssetBank::class)->make();
        $bankIN->name = 'BNI';
        $bankIN->status = false;
        $bankIN->save();

        //call actual method
        $existingCountries = AssetBank::inst()
            ->filter(AssetBank::STATUS_ACTIVE, 'bank');

        //checking code
        $this->assertEquals($existingCountries->count(), 2);
        $this->assertEquals($existingCountries->first()->status, true);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_create_a_data()
    {
        $bankObj = factory(AssetBank::class)->make();

        $storedBank = AssetBank::inst()->storeExec($bankObj);

        $this->assertEquals($storedBank->name, $bankObj->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_update_the_data()
    {
        $bankObj = factory(AssetBank::class)->create();

        $newBank = factory(AssetBank::class)->make();

        $updatedBank = AssetBank::inst()->updateExec($newBank, $bankObj->id);

        $this->assertEquals($updatedBank->name, $newBank->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_the_data()
    {
        $bankObj = factory(AssetBank::class)->create();

        $deletedBank = AssetBank::inst()->destroyExec($bankObj->id);

        $this->assertTrue($deletedBank);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_some_data()
    {
        $bankObjects = factory(AssetBank::class, 3)->create();

        $ids = "";

        foreach ($bankObjects->toArray() as $k => $v) {
            $ids .= count($bankObjects->toArray()) - 1 !== $k
                ? $v['id'] . ","
                : $v['id'];
        }

        $deletedBank = AssetBank::inst()->destroySomeExec($ids);

        $this->assertTrue($deletedBank);
    }

//    /**
//     */
//    public function test_if_data_does_not_exist_it_can_not_delete_some_data()
//    {
//        try {
//            AssetBank::inst()->destroySomeExec("123,34");
//        } catch (\Exception $e) {
//
//        }
//
//    }

}
