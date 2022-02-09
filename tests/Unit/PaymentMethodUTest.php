<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetPaymentMethod;

class PaymentMethodUTest extends \TestCase
{

    public function test_if_status_value_is_empty_it_must_be_rejected()
    {
        $paymentMethod = factory(AssetPaymentMethod::class)->make();
        $paymentMethod->status = '';
        $paymentMethod->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($paymentMethod, 'status'), false);
    }

    public function test_if_status_value_is_null_it_must_be_rejected()
    {
        $paymentMethod = factory(AssetPaymentMethod::class)->make();
        $paymentMethod->status = null;
        $paymentMethod->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($paymentMethod, 'status'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $paymentMethod_statuses = [0, 1];

        foreach ($paymentMethod_statuses as $status) {
            $paymentMethod = factory(AssetPaymentMethod::class)->make();
            $paymentMethod->status = $status;
            $paymentMethod->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($paymentMethod, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $paymentMethod = factory(AssetPaymentMethod::class)->make();
        $paymentMethod->status = 'status';
        $paymentMethod->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($paymentMethod, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $paymentMethod_statuses = [-1, 2, 3, 4];

        foreach ($paymentMethod_statuses as $status) {
            $paymentMethod = factory(AssetPaymentMethod::class)->make();
            $paymentMethod->status = $status;
            $paymentMethod->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($paymentMethod, 'status'), false);
        }
    }

    public function test_if_required_name_value_is_empty_it_must_be_rejected()
    {
        $paymentMethod = factory(AssetPaymentMethod::class)->make();
        $paymentMethod->name = '';
        $paymentMethod->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($paymentMethod, 'name'), false);
    }

    public function test_if_required_name_value_is_null_it_must_be_rejected()
    {
        $paymentMethod = factory(AssetPaymentMethod::class)->make();
        $paymentMethod->name = null;
        $paymentMethod->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($paymentMethod, 'name'), false);
    }

    public function test_if_code_duplicated_it_must_be_rejected()
    {
        #prepare data
        $paymentMethod1 = factory(AssetPaymentMethod::class)->make();
        $paymentMethod1->name = 'Cash';
        $paymentMethod1->save();

        $paymentMethod2 = factory(AssetPaymentMethod::class)->make();
        $paymentMethod2->name = 'Cash';
        $paymentMethod2->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($paymentMethod2, 'name'), false);
    }

    public function test_it_saves_valid_country_it_can_be_created()
    {
        $paymentMethod = factory(AssetPaymentMethod::class)->make();
        $this->assertEquals($paymentMethod->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        $countries = factory(AssetPaymentMethod::class, 5)->make();

        $this->assertEquals(count($countries), 5);
    }

    public function test_if_search_data_by_key_its_must_be_founded()
    {
        //assumption
        $paymentMethodID = factory(AssetPaymentMethod::class)->make();
        $paymentMethodID->name = 'Cash';
        $paymentMethodID->save();

        $paymentMethodIN = factory(AssetPaymentMethod::class)->make();
        $paymentMethodIN->name = 'Cash Payment';
        $paymentMethodIN->save();

        //call actual method
        $totPaymentMethodFound = AssetPaymentMethod::inst()
            ->filter('', 'cash')->count();

        //checking code
        $this->assertEquals(2, $totPaymentMethodFound);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetPaymentMethod::class, 5)->make();

        $paymentMethodID = factory(AssetPaymentMethod::class)->make();
        $paymentMethodID->name = 'BANK TRANSFER';
        $paymentMethodID->status = true;
        $paymentMethodID->save();

        $paymentMethodIN = factory(AssetPaymentMethod::class)->make();
        $paymentMethodIN->name = 'CASH';
        $paymentMethodIN->status = false;
        $paymentMethodIN->save();

        $paymentMethodIN = factory(AssetPaymentMethod::class)->make();
        $paymentMethodIN->name = 'CREDIT CARD';
        $paymentMethodIN->status = false;
        $paymentMethodIN->save();

        //call actual method
        $existingCountries = AssetPaymentMethod::inst()
            ->filter(AssetPaymentMethod::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingCountries->count(), 1);
        $this->assertEquals($existingCountries->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetPaymentMethod::class, 5)->make();

        $paymentMethodID = factory(AssetPaymentMethod::class)->make();
        $paymentMethodID->name = 'BANK TRANSFER';
        $paymentMethodID->status = true;
        $paymentMethodID->save();

        $paymentMethodIN = factory(AssetPaymentMethod::class)->make();
        $paymentMethodIN->name = 'CREDIT CARD BANK';
        $paymentMethodIN->status = true;
        $paymentMethodIN->save();

        $paymentMethodIN = factory(AssetPaymentMethod::class)->make();
        $paymentMethodIN->name = 'CASH';
        $paymentMethodIN->status = false;
        $paymentMethodIN->save();

        //call actual method
        $existingCountries = AssetPaymentMethod::inst()
            ->filter(AssetPaymentMethod::STATUS_ACTIVE, 'bank');

        //checking code
        $this->assertEquals($existingCountries->count(), 2);
        $this->assertEquals($existingCountries->first()->status, true);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_create_a_data()
    {
        $paymentMethodObj = factory(AssetPaymentMethod::class)->make();

        $storedBank = AssetPaymentMethod::inst()->storeExec($paymentMethodObj);

        $this->assertEquals($storedBank->name, $paymentMethodObj->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_update_the_data()
    {
        $paymentMethodObj = factory(AssetPaymentMethod::class)->create();

        $newBank = factory(AssetPaymentMethod::class)->make();

        $updatedBank = AssetPaymentMethod::inst()->updateExec($newBank, $paymentMethodObj->id);

        $this->assertEquals($updatedBank->name, $newBank->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_the_data()
    {
        $paymentMethodObj = factory(AssetPaymentMethod::class)->create();

        $deletedBank = AssetPaymentMethod::inst()->destroyExec($paymentMethodObj->id);

        $this->assertTrue($deletedBank);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_some_data()
    {
        $paymentMethodObjects = factory(AssetPaymentMethod::class, 3)->create();

        $ids = "";

        foreach ($paymentMethodObjects->toArray() as $k => $v) {
            $ids .= count($paymentMethodObjects->toArray()) - 1 !== $k
                ? $v['id'] . ","
                : $v['id'];
        }

        $deletedBank = AssetPaymentMethod::inst()->destroySomeExec($ids);

        $this->assertTrue($deletedBank);
    }

//    /**
//     */
//    public function test_if_data_does_not_exist_it_can_not_delete_some_data()
//    {
//        try {
//            AssetPaymentMethod::inst()->destroySomeExec("123,34");
//        } catch (\Exception $e) {
//
//        }
//
//    }

}
