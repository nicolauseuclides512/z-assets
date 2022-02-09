<?php


use Illuminate\Database\Migrations\Migration;

class CreateAssetWeightUnitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CustomBlueprint::inst()->create('asset_weight_units', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 5)->nullable();
            $table->string('name', 50)->nullable();
            $table->boolean('status')->default(true)->nullable();

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
        Schema::dropIfExists('asset_weight_units');
    }
}
