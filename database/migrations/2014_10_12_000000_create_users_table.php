<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        CustomBlueprint::inst()->create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->rememberToken();

            $table->string('username', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('password')->nullable();
            $table->string('full_name', 100)->nullable();
            $table->string('nickname', 50)->nullable();
            $table->tinyInteger('gender')->nullable();
            $table->boolean('status')->default(true)->nullable();
            $table->bigInteger('country_id')->unsigned()->nullable();
            $table->bigInteger('timezone_id')->unsigned()->nullable();
            $table->string('token')->nullable();
            $table->string('invitation_code')->nullable();
            $table->string('reset_code')->nullable();
            $table->string('photo')->nullable();
            $table->string('verification_code')->nullable();

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
        Schema::dropIfExists('users');
    }
}
