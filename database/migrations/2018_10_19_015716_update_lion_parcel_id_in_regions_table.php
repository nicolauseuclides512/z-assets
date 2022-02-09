<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateLionParcelIdInRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::Transaction(function () {
            $this->updateLionParcelId();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }

    private function updateLionParcelId()
    {
        printf('update Lion parcel id ');
        $regionsCsvFile = base_path() . "/public/src/relate_lionparcel_regions.csv";
        $regionsCsvResult = \App\Utils\CsvConverter::csvToArray($regionsCsvFile);

        array_map(function ($x) {
            DB::table('asset_regions')
                ->where('id', $x['region_id'])
                ->update(['lion_parcel_id' => $x['lion_parcel_id']]);
            printf('update ' . $x['region_id'] . '\n');
        }, $regionsCsvResult);
    }

}
