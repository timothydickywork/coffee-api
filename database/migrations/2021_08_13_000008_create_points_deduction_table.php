<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePointsDeductionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points_deduction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('promo_id')->unsigned()->nullable();
            $table->foreign('promo_id')->references('id')->on('promo');
            $table->string('customer_code');
            $table->foreign('customer_code')->references('code')->on('customer');
            $table->integer('points_reduced');
            $table->dateTime('date');
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
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('points_deduction');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
