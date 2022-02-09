<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Migrations\Migration;

class AlterDateAllColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        $tabels = [
            'users',
            'asset_currencies',
            'asset_weight_units',
            'asset_carriers',
            'asset_timezones',
            'asset_countries',
            'asset_provinces',
            'asset_districts',
            'asset_regions',
            'asset_languages',
            'asset_banks',
            'asset_payment_methods'
        ];

        foreach ($tabels as $tbl) {
            DB::unprepared("
BEGIN;

ALTER TABLE $tbl DROP COLUMN created_at;
ALTER TABLE $tbl DROP COLUMN updated_at;
ALTER TABLE $tbl DROP COLUMN deleted_at;

ALTER TABLE $tbl ADD COLUMN created_at TIMESTAMP;
ALTER TABLE $tbl ADD COLUMN updated_at TIMESTAMP;
ALTER TABLE $tbl ADD COLUMN deleted_at TIMESTAMP;

UPDATE $tbl SET created_at=NOW(), updated_at=NOW(),  deleted_at=NULL;

COMMIT;
");

        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
