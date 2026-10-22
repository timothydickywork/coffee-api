<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateVoucherTransactionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('promo_id')->unsigned();
            $table->foreign('promo_id')->references('id')->on('promo');
            $table->string('customer_code');
            $table->foreign('customer_code')->references('code')->on('customer');
            $table->bigInteger('store_id')->unsigned()->nullable();
            $table->foreign('store_id')->references('id')->on('store');
            $table->bigInteger('transaction_id')->unsigned()->nullable();
            $table->foreign('transaction_id')->references('id')->on('transaction');
            $table->string('transaction_number')->nullable();
            $table->string('code');
            $table->dateTime('using_date')->nullable();
            $table->date('expired_date');
            $table->string('title');
            $table->string('description', 1024);
            $table->longtext('image_a')->nullable();
            $table->longtext('image_b')->nullable();
            $table->enum('type', ['Percentage', 'Price']);
            $table->double('value')->nullable()->unsigned();
            $table->double('value_max')->nullable()->unsigned();
            $table->integer('transaction_min')->nullable()->unsigned();
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
        Schema::dropIfExists('voucher_transaction');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
