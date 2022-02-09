<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class RecreateAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('asset_countries');
        Schema::dropIfExists('asset_provinces');
        Schema::dropIfExists('asset_districts');
        Schema::dropIfExists('asset_regions');

        CustomBlueprint::inst()->create('asset_countries', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 3)->nullable();
            $table->string('name', 100)->nullable();
            $table->boolean('status')->default(true)->nullable();

            $table->defaultColumn();

        });

        CustomBlueprint::inst()->create('asset_provinces', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('country_id')->unsigned();
            $table->string('name', 100)->nullable();
            $table->boolean('status')->default(true)->nullable();

            $table->defaultColumn();
        });

        CustomBlueprint::inst()->create('asset_districts', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('province_id')->unsigned();
            $table->string('name', 100)->nullable();
            $table->string('type', 100)->nullable();
            $table->string('zip', 10)->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->bigInteger("lion_parcel_id")->nullable()->unsigned();

            $table->defaultColumn();

        });

        CustomBlueprint::inst()->create('asset_regions', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->bigInteger('district_id')->unsigned();
            $table->string('type', 100)->nullable();
            $table->string('zip', 10)->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->bigInteger("lion_parcel_id")->nullable()->unsigned();
            $table->boolean('is_priority')->default(false);

            $table->defaultColumn();

        });

        ini_set('memory_limit', '-1');

        DB::unprepared(File::get(base_path() . '/etc/postgres/sql/countries.sql'));
        DB::unprepared(File::get(base_path() . '/etc/postgres/sql/provinces.sql'));
        DB::unprepared(File::get(base_path() . '/etc/postgres/sql/districts.sql'));
        DB::unprepared(File::get(base_path() . '/etc/postgres/sql/regions.sql'));
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
