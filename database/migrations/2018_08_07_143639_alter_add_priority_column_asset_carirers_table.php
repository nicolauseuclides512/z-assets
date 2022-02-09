<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddPriorityColumnAssetCarirersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {


        Schema::table('asset_carriers', function (Blueprint $table) {
            $table->integer('priority')->nullable();
        });

        DB::Transaction(function () {
            DB::update("UPDATE asset_carriers SET priority=1 WHERE code='jne'");
            DB::update("UPDATE asset_carriers SET priority=2 WHERE code='jnt'");
            DB::update("UPDATE asset_carriers SET priority=3 WHERE code='pos'");
            DB::update("UPDATE asset_carriers SET priority=4 WHERE code='tiki'");
            DB::update("UPDATE asset_carriers SET priority=5 WHERE code='wahana'");
            DB::update("UPDATE asset_carriers SET priority=6 WHERE code='sicepat'");
            DB::update("UPDATE asset_carriers SET priority=7 WHERE code='lp'");
            DB::update("UPDATE asset_carriers SET priority=8 WHERE code='sap'");
            DB::update("UPDATE asset_carriers SET priority=9 WHERE code='esl'");
            DB::update("UPDATE asset_carriers SET priority=10 WHERE code='first'");
            DB::update("UPDATE asset_carriers SET priority=11 WHERE code='indah'");
            DB::update("UPDATE asset_carriers SET priority=12 WHERE code='jet'");
            DB::update("UPDATE asset_carriers SET priority=13 WHERE code='ncs'");
            DB::update("UPDATE asset_carriers SET priority=14 WHERE code='pandu'");
            DB::update("UPDATE asset_carriers SET priority=15 WHERE code='rpx'");
            DB::update("UPDATE asset_carriers SET priority=16 WHERE code='pcp'");
            DB::update("UPDATE asset_carriers SET priority=17 WHERE code='dse'");
            DB::update("UPDATE asset_carriers SET priority=18 WHERE code='pahala'");
            DB::update("UPDATE asset_carriers SET priority=19 WHERE code='cahaya'");
            DB::update("UPDATE asset_carriers SET priority=20 WHERE code='slis'");
            DB::update("UPDATE asset_carriers SET priority=21 WHERE code='nss'");
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
            $table->dropColumn('priority');
        });
    }
}
