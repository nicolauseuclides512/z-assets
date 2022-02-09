<?php


use Illuminate\Database\Migrations\Migration;

class CreateAssetLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CustomBlueprint::inst()->create('asset_languages', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->string('code', 100)->nullable();
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
        Schema::dropIfExists('asset_languages');
    }
}
