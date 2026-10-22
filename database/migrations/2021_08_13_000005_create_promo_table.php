<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('description', 1024);
            $table->longtext('image_a');
            $table->longtext('image_b');
            $table->enum('type', ['Percentage', 'Price']);
            $table->double('value')->unsigned();
            $table->integer('value_max')->nullable()->unsigned();
            $table->integer('transaction_min')->nullable()->unsigned();
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('expiration_day');
            $table->integer('price_points')->nullable();
            $table->integer('exchange_limit')->unsigned()->nullable();
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
        Schema::dropIfExists('promo');
    }
}
