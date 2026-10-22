<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAppKeyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_key', function (Blueprint $table) {
            $table->bigIncrements('app_key_id');
            $table->longText('app_key_name');
            $table->boolean('app_key_active');
            $table->longText('app_key_value');
            $table->longText('app_key_aes_cbc');
            $table->longText('app_key_aes_cbc_iv');
            $table->longText('app_key_checksum');
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
        Schema::dropIfExists('app_key');
    }
}
