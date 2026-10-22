<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateCustomerFirebaseTokenTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_firebase_token', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('customer_code');
            $table->foreign('customer_code')->references('code')->on('customer');
            $table->string('firebase_token')->unique();
            $table->string('system_token')->unique();
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
        Schema::dropIfExists('customer_firebase_token');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
