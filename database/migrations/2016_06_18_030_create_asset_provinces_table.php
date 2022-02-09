<?php


use Illuminate\Database\Migrations\Migration;

class CreateAssetProvincesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CustomBlueprint::inst()->create('asset_provinces', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('country_id')->unsigned();
            $table->string('name', 100)->nullable();
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
        Schema::dropIfExists('asset_provinces');
    }
}
