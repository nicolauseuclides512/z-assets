<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddIsDefatultColumnAssetCarrierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_carriers', function (Blueprint $table) {
            $table->boolean("is_default")->default(false);
        });

        DB::Transaction(function () {
            DB::update("UPDATE asset_carriers SET is_default=TRUE WHERE code='jne'");
            DB::update("UPDATE asset_carriers SET is_default=TRUE WHERE code='jnt'");
            DB::update("UPDATE asset_carriers SET is_default=TRUE WHERE code='pos'");
            DB::update("UPDATE asset_carriers SET is_default=TRUE WHERE code='tiki'");
            DB::update("UPDATE asset_carriers SET is_default=TRUE WHERE code='wahana'");
            DB::update("UPDATE asset_carriers SET is_default=TRUE WHERE code='sicepat'");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('asset_carriers', function (Blueprint $table) {
            $table->dropColumn('is_default');
        });
    }
}
