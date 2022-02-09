<?php
/**
 * @author Jehan Afwazi Ahmad <jehan.afwazi@gmail.com>.
 */

namespace App\Tests\Feature;


use App\Models\AssetLanguage;

class LanguageUTest extends \TestCase
{

    public function test_if_required_code_value_is_empty_it_must_be_rejected()
    {
        $language = factory(AssetLanguage::class)->make();
        $language->code = '';
        $language->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($language, 'code'), false);
    }

    public function test_if_required_code_value_is_null_it_must_be_rejected()
    {
        $language = factory(AssetLanguage::class)->make();
        $language->code = null;
        $language->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($language, 'code'), false);
    }

    public function test_if_code_duplicated_it_must_be_rejected()
    {
        #prepare data
        $language1 = factory(AssetLanguage::class)->make();
        $language1->code = 'EN';
        $language1->save();

        $language2 = factory(AssetLanguage::class)->make();
        $language2->code = 'EN';
        $language2->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($language2, 'code'), false);
    }

    public function test_if_required_name_value_is_empty_it_must_be_rejected()
    {
        $language = factory(AssetLanguage::class)->make();
        $language->name = '';
        $language->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($language, 'name'), false);
    }

    public function test_if_required_name_value_is_null_it_must_be_rejected()
    {
        $language = factory(AssetLanguage::class)->make();
        $language->name = null;
        $language->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($language, 'name'), false);
    }

    public function test_if_status_value_set_0_or_1_it_can_be_created()
    {
        #prepare data
        $language_statuses = array(0, 1);

        foreach ($language_statuses as $status) {
            $language = factory(AssetLanguage::class)->make();
            $language->status = $status;
            $language->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($language, 'status'), true);
        }
    }

    public function test_if_status_field_is_not_boolean_or_0_1_integer_must_be_rejected()
    {
        $language = factory(AssetLanguage::class)->make();
        $language->status = 'status';
        $language->save();

        #checking error message
        $this->assertEquals($this->isValidationPass($language, 'status'), false);
    }

    public function test_if_status_value_is_out_of_range_it_must_be_rejected()
    {
        #prepare data
        $language_statuses = array(-1, 2, 3, 4);

        foreach ($language_statuses as $status) {
            $language = factory(AssetLanguage::class)->make();
            $language->status = $status;
            $language->save();

            #checking error message
            $this->assertEquals($this->isValidationPass($language, 'status'), false);
        }
    }

    public function test_it_saves_valid_data_it_can_be_created()
    {
        $language = factory(AssetLanguage::class)->make();
        $this->assertEquals($language->save(), true);
    }

    public function test_if_it_fetch_it_must_be_expected_record()
    {
        $countries = factory(AssetLanguage::class, 5)->make();

        $this->assertEquals(count($countries), 5);
    }

    public function test_if_search_data_by_key_name_its_must_be_founded()
    {
        //assumption

        $language1 = factory(AssetLanguage::class)->make();
        $language1->code = 'EN';
        $language1->name = 'English';
        $language1->save();

        $language2 = factory(AssetLanguage::class)->make();
        $language2->code = 'ID';
        $language2->name = 'Indonesia';
        $language2->save();

        //call actual method

        $totalDataFoundByCode = AssetLanguage::inst()
            ->filter('', 'en')
            ->count();

        $totalDataFoundByName = AssetLanguage::inst()
            ->filter('', 'indone')
            ->count();

        //checking code
        $this->assertEquals($totalDataFoundByCode, 1);
        $this->assertEquals($totalDataFoundByName, 1);
    }

    public function test_if_filter_data_its_must_be_filtered()
    {
        //assumption
        $language1 = factory(AssetLanguage::class)->make();
        $language1->code = 'EN';
        $language1->name = 'English';
        $language1->status = true;
        $language1->save();

        $language2 = factory(AssetLanguage::class)->make();
        $language2->code = 'ID';
        $language2->name = 'Indonesia';
        $language2->status = false;
        $language2->save();

        $language3 = factory(AssetLanguage::class)->make();
        $language3->code = 'IN';
        $language3->name = 'India';
        $language3->status = false;
        $language3->save();

        //call actual method
        $existingCarrier = AssetLanguage::inst()
            ->filter(AssetLanguage::STATUS_ACTIVE, '');

        //checking code
        $this->assertEquals($existingCarrier->count(), 1);
        $this->assertEquals($existingCarrier->first()->status, true);
    }

    public function test_if_filter_and_search_data_its_must_be_filtered()
    {
        //assumption
        $language1 = factory(AssetLanguage::class)->make();
        $language1->code = 'EN';
        $language1->name = 'English';
        $language1->status = false;
        $language1->save();

        $language2 = factory(AssetLanguage::class)->make();
        $language2->code = 'ID';
        $language2->name = 'Indonesia';
        $language2->status = true;
        $language2->save();

        $language3 = factory(AssetLanguage::class)->make();
        $language3->code = 'IN';
        $language3->name = 'India';
        $language3->status = true;
        $language3->save();

        //call actual method
        $existingCurrency = AssetLanguage::inst()
            ->filter(AssetLanguage::STATUS_ACTIVE, 'ind');

        //checking code
        $this->assertEquals(2, $existingCurrency->count());
        $this->assertEquals(true, $existingCurrency->first()->status);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_create_a_data()
    {
        $languageObj = factory(AssetLanguage::class)->make();

        $storedBank = AssetLanguage::inst()->storeExec($languageObj);

        $this->assertEquals($storedBank->name, $languageObj->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_update_the_data()
    {
        $languageObj = factory(AssetLanguage::class)->create();

        $newBank = factory(AssetLanguage::class)->make();

        $updatedBank = AssetLanguage::inst()->updateExec($newBank, $languageObj->id);

        $this->assertEquals($updatedBank->name, $newBank->name);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_the_data()
    {
        $languageObj = factory(AssetLanguage::class)->create();

        $deletedBank = AssetLanguage::inst()->destroyExec($languageObj->id);

        $this->assertTrue($deletedBank);
    }

    /**
     * @throws \Exception
     */
    public function test_it_can_delete_some_data()
    {
        $languageObjects = factory(AssetLanguage::class, 3)->create();

        $ids = "";

        foreach ($languageObjects->toArray() as $k => $v) {
            $ids .= count($languageObjects->toArray()) - 1 !== $k
                ? $v['id'] . ","
                : $v['id'];
        }

        $deletedBank = AssetLanguage::inst()->destroySomeExec($ids);

        $this->assertTrue($deletedBank);
    }

}
