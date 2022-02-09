<?php


use Illuminate\Database\Migrations\Migration;

class CreateAssetCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        CustomBlueprint::inst()->create('asset_countries', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->string('code', 3)->nullable();
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
        Schema::dropIfExists('asset_countries');
    }
}
