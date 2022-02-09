<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterAddEnableColumnInOngkirCekresiInAssetCarriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('asset_carriers');

        ini_set('memory_limit', '-1');


        CustomBlueprint::inst()->create('asset_carriers', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status')->default(false);
            $table->string('name', 50)->nullable();
            $table->string('code', 50)->nullable();
            $table->string('logo', 255)->nullable();
            $table->boolean("is_shipping_cost_on")->default(false);
            $table->boolean("is_track_shipment_on")->default(false);

            $table->defaultColumn();
        });

        DB::unprepared(File::get(base_path() . '/etc/postgres/sql/carriers.sql'));

        DB::Transaction(function () {

            DB::insert("INSERT INTO asset_carriers (name,code,logo,status,is_shipping_cost_on,is_track_shipment_on,created_at,updated_at,created_by) VALUES ('Lion Parcel','lp','https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/lp_id.png',TRUE ,TRUE ,TRUE , now(), now(), 'anonymous')");
            DB::insert("INSERT INTO asset_carriers (name,code,logo,status,is_shipping_cost_on,is_track_shipment_on,created_at,updated_at,created_by) VALUES ('Nss Express','nss','https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/nss_id.png',TRUE ,FALSE ,TRUE , now(), now(),'anonymous')");

            //active all feat
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=TRUE WHERE code='jne'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=TRUE WHERE code='pos'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=TRUE WHERE code='tiki'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=TRUE WHERE code='pcp'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=FALSE WHERE code='esl'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=TRUE WHERE code='rpx'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=FALSE WHERE code='pandu'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=TRUE WHERE code='wahana'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=TRUE WHERE code='sicepat'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=TRUE WHERE code='jnt'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=FALSE WHERE code='pahala'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=FALSE WHERE code='cahaya'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=FALSE WHERE code='sap'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=TRUE WHERE code='jet'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=FALSE WHERE code='indah'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=TRUE WHERE code='slis'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=TRUE WHERE code='dse'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=TRUE WHERE code='first'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=FALSE WHERE code='ncs'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=TRUE, is_track_shipment_on=TRUE WHERE code='lp'");
            DB::update("UPDATE asset_carriers SET is_shipping_cost_on=FALSE, is_track_shipment_on=TRUE WHERE code='nss'");


            DB::update("UPDATE asset_carriers SET status=TRUE ");

            DB::update("UPDATE asset_carriers SET logo='https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/jne_id.png' WHERE code='jne'");
            DB::update("UPDATE asset_carriers SET logo='https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/pos_id.png' WHERE code='pos'");
            DB::update("UPDATE asset_carriers SET logo='https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/tiki_id.png' WHERE code='tiki'");
            DB::update("UPDATE asset_carriers SET logo='https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/wahana_id.png' WHERE code='wahana'");
            DB::update("UPDATE asset_carriers SET logo='https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/sicepat_id.png' WHERE code='sicepat'");
            DB::update("UPDATE asset_carriers SET logo='https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/jnt_id.png' WHERE code='jnt'");
            DB::update("UPDATE asset_carriers SET logo='https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/rpx_id.png' WHERE code='rpx'");
            DB::update("UPDATE asset_carriers SET logo='https://s3-ap-southeast-1.amazonaws.com/sahitotest/assets/carriers/first_id.png' WHERE code='first'");


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
            $table->dropColumn("is_shipping_cost_on");
            $table->dropColumn("is_track_shipment_on");

            DB::delete("DELETE FROM asset_carriers WHERE code = 'lp'");
            DB::delete("DELETE FROM asset_carriers WHERE code = 'nss'");
        });
    }
}
