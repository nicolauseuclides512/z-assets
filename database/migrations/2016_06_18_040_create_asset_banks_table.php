<?php

use Illuminate\Database\Migrations\Migration;

class CreateAssetBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CustomBlueprint::inst()->create('asset_banks', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->string('logo')->nullable();
            $table->boolean('status')->default(false);
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
        Schema::dropIfExists('asset_banks');
    }
}
