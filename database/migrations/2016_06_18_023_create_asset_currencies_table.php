<?php



use Illuminate\Database\Migrations\Migration;

class CreateAssetCurrenciesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		CustomBlueprint::inst()->create('asset_currencies', function (CustomBlueprint $table) {
			$table->bigIncrements('id');
			$table->char('code', 3)->nullable();
			$table->char('symbol', 3)->nullable();
			$table->string('name', 50)->nullable();
			$table->char('iso_2', 2)->nullable();
			$table->char('iso_3', 3)->nullable();
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
		Schema::dropIfExists('asset_currencies');
	}
}
