<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateAssetLionParcelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CustomBlueprint::inst()->create('asset_lion_parcels', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->string("area_code")->nullable();
            $table->string("city")->nullable();
            $table->string("booking_route")->nullable();
            $table->string("cost_route")->nullable();
            $table->boolean("is_city")->nullable();
            $table->boolean("status")->nullable()->default(true);

            $table->defaultColumn();
        });

        ini_set('memory_limit', '-1');

        DB::unprepared(File::get(base_path() . '/etc/postgres/sql/8_asset_lion_parcel.sql'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_lion_parcels');
    }
}
