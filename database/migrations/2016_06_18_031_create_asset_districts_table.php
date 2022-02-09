<?php



use Illuminate\Database\Migrations\Migration;

class CreateAssetDistrictsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		CustomBlueprint::inst()->create('asset_districts', function (CustomBlueprint $table) {
			$table->bigIncrements('id');
			$table->bigInteger('province_id')->unsigned();
            $table->string('name', 100)->nullable();
			$table->string('type', 100)->nullable();
			$table->string('zip', 10)->nullable();
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
		Schema::dropIfExists('asset_districts');
	}
}
