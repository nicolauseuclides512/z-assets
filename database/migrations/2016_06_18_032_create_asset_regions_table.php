<?php



use Illuminate\Database\Migrations\Migration;

class CreateAssetRegionsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{

		CustomBlueprint::inst()->create('asset_regions', function (CustomBlueprint $table) {
			$table->bigIncrements('id');
            $table->string('name', 100)->nullable();
            $table->bigInteger('district_id')->unsigned();
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
		Schema::dropIfExists('asset_regions');
	}
}
