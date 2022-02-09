<?php

use Illuminate\Database\Migrations\Migration;

class CreateAssetPaymentMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CustomBlueprint::inst()->create('asset_payment_methods', function (CustomBlueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->string('description', 1000)->nullable();
            $table->tinyInteger('status')->nullable();

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
        Schema::dropIfExists('asset_payment_methods');
    }
}
