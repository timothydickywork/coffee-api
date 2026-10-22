<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePointsAddictionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points_addiction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('setup_points_id')->unsigned();
            $table->foreign('setup_points_id')->references('id')->on('setup_points');
            $table->string('customer_code');
            $table->foreign('customer_code')->references('code')->on('customer');
            $table->bigInteger('transaction_id')->unsigned();
            $table->foreign('transaction_id')->references('id')->on('transaction');
            $table->string('transaction_number');
            $table->dateTime('date');
            $table->date('expired_date');
            $table->integer('points_added');
            $table->integer('points_active');
            $table->string('user_create')->nullable();
            $table->string('user_update')->nullable();
            $table->string('user_delete')->nullable();
            $table->string('delete_reason')->nullable();
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('points_addiction');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
