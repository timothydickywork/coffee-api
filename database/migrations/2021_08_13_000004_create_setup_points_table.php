<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetupPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setup_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('min_transaction')->unsigned();
            $table->date('start_date');
            $table->integer('expiration_day')->unsigned();
            $table->string('user_create')->nullable();
            $table->string('user_update')->nullable();
            $table->string('user_delete')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setup_points');
    }
}
