<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetWeightUnit;

class WeightUnitUTest extends \TestCase
{

    public function test_if_code_value_is_empty_it_must_be_rejected()
    {
        #prepare data
        $weightUnit = factory(AssetWeightUnit::class)->make();
        $weightUnit->code = '';
        $weightUnit->save();

        #checking error message
        $this->assertEquals(false, $this->isValidationPass($weightUnit, 'code'));
    }

    public function test_if_code_value_is_null_it_must_be_rejected()
    {
        #prepare data
        $weightUnit = factory(AssetWeightUnit::class)->make();
        $weightUnit->code = null;
        $weightUnit->save();

        #checking error message
        $this->assertEquals(false, $this->isValidationPass($weightUnit, 'code'));
    }

    public function test_if_status_value_is_empty_it_must_be_rejected()
    {
        $weightUnit = factory(AssetWeightUnit::class)->make();
        $weightUnit->status = '';
        $weightUnit->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($weightUnit, 'status'), false);
    }

    public function test_if_status_value_is_null_it_must_be_rejected()
    {
        $weightUnit = factory(AssetWeightUnit::class)->make();
        $weightUnit->status = null;
        $weightUnit->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($weightUnit, 'status'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $weightUnit_statuses = [0, 1];

        foreach ($weightUnit_statuses as $status) {
            $weightUnit = factory(AssetWeightUnit::class)->make();
            $weightUnit->status = $status;
            $weightUnit->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($weightUnit, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $weightUnit = factory(AssetWeightUnit::class)->make();
        $weightUnit->status = 'status';
        $weightUnit->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($weightUnit, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $weightUnit_statuses = array(-1, 2, 3, 4);

        foreach ($weightUnit_statuses as $status) {
            $weightUnit = factory(AssetWeightUnit::class)->make();
            $weightUnit->status = $status;
            $weightUnit->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($weightUnit, 'status'), false);
        }
    }

    public function test_if_required_name_value_is_empty_it_must_be_rejected()
    {
        $weightUnit = factory(AssetWeightUnit::class)->make();
        $weightUnit->name = '';
        $weightUnit->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($weightUnit, 'name'), false);
    }

    public function test_if_required_name_value_is_null_it_must_be_rejected()
    {
        $weightUnit = factory(AssetWeightUnit::class)->make();
        $weightUnit->name = null;
        $weightUnit->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($weightUnit, 'name'), false);
    }

    public function test_if_code_duplicated_it_must_be_rejected()
    {
        #prepare data
        $weightUnit = factory(AssetWeightUnit::class)->make();
        $weightUnit->code = 'USA';
        $weightUnit->save();

        $existing_country = factory(AssetWeightUnit::class)->make();
        $existing_country->code = 'USA';
        $existing_country->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($existing_country, 'code'), false);
    }

    public function test_it_saves_valid_country_it_can_be_created()
    {
        $weightUnit = factory(AssetWeightUnit::class)->make();
        $this->assertEquals($weightUnit->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        $countries = factory(AssetWeightUnit::class, 5)->make();

        $this->assertEquals(count($countries), 5);
    }

    public function test_if_search_data_by_key_code_its_must_be_founded()
    {
        //assumption
        $weightUnit1 = factory(AssetWeightUnit::class)->make();
        $weightUnit1->code = 'ounce';
        $weightUnit1->name = 'ounce';
        $weightUnit1->save();

        $weightUnit2 = factory(AssetWeightUnit::class)->make();
        $weightUnit2->code = 'kg';
        $weightUnit2->name = 'Kilogram';
        $weightUnit2->save();

        //call actual method
        $totWeighUnitFound = AssetWeightUnit::inst()
            ->filter('', 'kg')
            ->count();

        //checking code
        $this->assertEquals(1, $totWeighUnitFound);
    }

    public function test_if_search_data_by_key_name_its_must_be_founded()
    {
        //assumption
        $weightUnit1 = factory(AssetWeightUnit::class)->make();
        $weightUnit1->code = 'gr';
        $weightUnit1->name = 'gram';
        $weightUnit1->save();

        $weightUnit2 = factory(AssetWeightUnit::class)->make();
        $weightUnit2->code = 'kg';
        $weightUnit2->name = 'Kilogram';
        $weightUnit2->save();

        //call actual method
        $totWeighUnitFound = AssetWeightUnit::inst()
            ->filter('', 'gram')
            ->count();

        //checking code
        $this->assertEquals(2, $totWeighUnitFound);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption
        $weightUnit1 = factory(AssetWeightUnit::class)->make();
        $weightUnit1->code = 'gr';
        $weightUnit1->name = 'Gram';
        $weightUnit1->status = true;
        $weightUnit1->save();

        $weightUnit2 = factory(AssetWeightUnit::class)->make();
        $weightUnit2->code = 'kg';
        $weightUnit2->name = 'Kilogram';
        $weightUnit2->status = false;
        $weightUnit2->save();

        $weightUnit3 = factory(AssetWeightUnit::class)->make();
        $weightUnit3->code = 'ounce';
        $weightUnit3->name = 'Ounce';
        $weightUnit3->status = false;
        $weightUnit2->save();

        //call actual method
        $existingCountries = AssetWeightUnit::inst()
            ->filter(AssetWeightUnit::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingCountries->count(), 1);
        $this->assertEquals($existingCountries->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_filtered()
    {
        //assumption
        $weightUnit1 = factory(AssetWeightUnit::class)->make();
        $weightUnit1->code = 'gr';
        $weightUnit1->name = 'Gram';
        $weightUnit1->status = true;
        $weightUnit1->save();

        $weightUnit2 = factory(AssetWeightUnit::class)->make();
        $weightUnit2->code = 'kg';
        $weightUnit2->name = 'Kilogram';
        $weightUnit2->status = true;
        $weightUnit2->save();

        $weightUnit3 = factory(AssetWeightUnit::class)->make();
        $weightUnit3->code = 'ounce';
        $weightUnit3->name = 'Ounce';
        $weightUnit3->status = false;
        $weightUnit2->save();

        //call actual method
        $existingCountries = AssetWeightUnit::inst()
            ->filter(AssetWeightUnit::STATUS_ACTIVE, 'gram');

        //checking code
        $this->assertEquals($existingCountries->count(), 2);
        $this->assertEquals($existingCountries->first()->status, true);
    }
}
