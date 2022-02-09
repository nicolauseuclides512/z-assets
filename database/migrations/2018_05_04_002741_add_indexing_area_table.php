<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIndexingAreaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('asset_countries', function (Blueprint $table) {
            $table->index(['id', 'name']);
        });

        Schema::table('asset_provinces', function (Blueprint $table) {
            $table->index(['id', 'name']);
        });

        Schema::table('asset_districts', function (Blueprint $table) {
            $table->index(['id', 'name']);
        });

        Schema::table('asset_regions', function (Blueprint $table) {
            $table->index(['id', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
