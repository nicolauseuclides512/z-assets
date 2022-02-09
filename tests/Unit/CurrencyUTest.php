<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetCurrency;

class CurrencyUTest extends \TestCase
{

    public function test_if_required_code_value_is_empty_it_must_be_rejected()
    {
        $currency = factory(AssetCurrency::class)->make();
        $currency->code = '';
        $currency->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($currency, 'code'), false);
    }

    public function test_if_required_code_value_is_null_it_must_be_rejected()
    {
        $currency = factory(AssetCurrency::class)->make();
        $currency->code = null;
        $currency->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($currency, 'code'), false);
    }

    public function test_if_code_duplicated_it_must_be_rejected()
    {
        #prepare data
        $currency1 = factory(AssetCurrency::class)->make();
        $currency1->code = 'JNE';
        $currency1->save();

        $currency2 = factory(AssetCurrency::class)->make();
        $currency2->code = 'JNE';
        $currency2->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($currency2, 'code'), false);
    }

    public function test_if_required_name_value_is_empty_it_must_be_rejected()
    {
        $currency = factory(AssetCurrency::class)->make();
        $currency->name = '';
        $currency->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($currency, 'name'), false);
    }

    public function test_if_required_name_value_is_null_it_must_be_rejected()
    {
        $currency = factory(AssetCurrency::class)->make();
        $currency->name = null;
        $currency->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($currency, 'name'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $currency_statuses = array(0, 1);

        foreach ($currency_statuses as $status) {
            $currency = factory(AssetCurrency::class)->make();
            $currency->status = $status;
            $currency->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($currency, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $currency = factory(AssetCurrency::class)->make();
        $currency->status = 'status';
        $currency->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($currency, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $currency_statuses = array(-1, 2, 3, 4);

        foreach ($currency_statuses as $status) {
            $currency = factory(AssetCurrency::class)->make();
            $currency->status = $status;
            $currency->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($currency, 'status'), false);
        }
    }

    public function test_it_saves_valid_data_it_can_be_created()
    {
        $currency = factory(AssetCurrency::class)->make();
        $this->assertEquals($currency->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        $countries = factory(AssetCurrency::class, 5)->make();

        $this->assertEquals(count($countries), 5);
    }

    public function test_if_search_data_by_key_name_its_must_be_founded()
    {
        //assumption

        $currencyID = factory(AssetCurrency::class)->make();
        $currencyID->code = 'IDR';
        $currencyID->name = 'Rupiah';
        $currencyID->symbol = 'Rp';
        $currencyID->save();

        $currencyIN = factory(AssetCurrency::class)->make();
        $currencyIN->code = 'USD';
        $currencyIN->name = 'Dollar';
        $currencyIN->symbol = '$';
        $currencyIN->save();

        //call actual method

        $totalDataFoundByCode = AssetCurrency::inst()
            ->filter('', 'IDR')
            ->count();

        $totalDataFoundByName = AssetCurrency::inst()
            ->filter('', 'rupi')
            ->count();

        $totalDataFoundBySymbol = AssetCurrency::inst()
            ->filter('', '$')
            ->count();

        //checking code
        $this->assertEquals($totalDataFoundByCode, 1);
        $this->assertEquals($totalDataFoundByName, 1);
        $this->assertEquals($totalDataFoundBySymbol, 1);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption
        $currency1 = factory(AssetCurrency::class)->make();
        $currency1->code = 'Rp';
        $currency1->name = 'Rupiah';
        $currency1->symbol = 'Rp';
        $currency1->status = true;
        $currency1->save();

        $currency2 = factory(AssetCurrency::class)->make();
        $currency2->code = 'USD';
        $currency2->name = 'Dollar';
        $currency2->symbol = '$';
        $currency2->status = false;
        $currency2->save();

        $currency3 = factory(AssetCurrency::class)->make();
        $currency3->code = 'RINGGIT';
        $currency3->name = 'Ringgit';
        $currency3->symbol = 'Ringgit';
        $currency3->status = false;
        $currency3->save();

        //call actual method
        $existingCarrier = AssetCurrency::inst()
            ->filter(AssetCurrency::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingCarrier->count(), 1);
        $this->assertEquals($existingCarrier->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_filtered()
    {
        //assumption
        factory(AssetCurrency::class, 5)->make();
        $currency1 = factory(AssetCurrency::class)->make();
        $currency1->code = 'Rp';
        $currency1->name = 'Rupiah';
        $currency1->symbol = 'Rp';
        $currency1->status = true;
        $currency1->save();

        $currency2 = factory(AssetCurrency::class)->make();
        $currency2->code = 'USD';
        $currency2->name = 'Dollar';
        $currency2->symbol = '$';
        $currency2->status = false;
        $currency2->save();

        $currency3 = factory(AssetCurrency::class)->make();
        $currency3->code = 'RPE';
        $currency3->name = 'Rupe';
        $currency3->symbol = 'RPE';
        $currency3->status = true;
        $currency3->save();

        //call actual method
        $existingCurrency = AssetCurrency::inst()
            ->filter(AssetCurrency::STATUS_ACTIVE, 'rup');

        //checking code
        $this->assertEquals(2, $existingCurrency->count());
        $this->assertEquals(true, $existingCurrency->first()->status);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_create_a_data()
    {
        $currencyObj = factory(AssetCurrency::class)->make();

        $storedBank = AssetCurrency::inst()->storeExec($currencyObj);

        $this->assertEquals($storedBank->name, $currencyObj->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_update_the_data()
    {
        $currencyObj = factory(AssetCurrency::class)->create();

        $newBank = factory(AssetCurrency::class)->make();

        $updatedBank = AssetCurrency::inst()->updateExec($newBank, $currencyObj->id);

        $this->assertEquals($updatedBank->name, $newBank->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_the_data()
    {
        $currencyObj = factory(AssetCurrency::class)->create();

        $deletedBank = AssetCurrency::inst()->destroyExec($currencyObj->id);

        $this->assertTrue($deletedBank);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_some_data()
    {
        $currencyObjects = factory(AssetCurrency::class, 3)->create();

        $ids = "";

        foreach ($currencyObjects->toArray() as $k => $v) {
            $ids .= count($currencyObjects->toArray()) - 1 !== $k
                ? $v['id'] . ","
                : $v['id'];
        }

        $deletedBank = AssetCurrency::inst()->destroySomeExec($ids);

        $this->assertTrue($deletedBank);
    }

//    /**
//     */
//    public function test_if_data_does_not_exist_it_can_not_delete_some_data()
//    {
//        try {
//            AssetCurrency::inst()->destroySomeExec("123,34");
//        } catch (\Exception $e) {
//
//        }
//
//    }

}
