<?php

use Illuminate\Database\Migrations\Migration;

class CreateAssetCarriersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CustomBlueprint::inst()->create('asset_carriers', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('status')->default(false);
            $table->string('name', 50)->nullable();
            $table->string('code', 50)->nullable();
            $table->string('logo', 255)->nullable();
            $table->defaultColumn();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asset_carriers');
    }
}
