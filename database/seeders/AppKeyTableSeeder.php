<?php

namespace Database\Seeders;

use App\Models\AppKey;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AppKeyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppKey::insert([
            'app_key_name' => "Postman",
            'app_key_active' => 1,
            'app_key_value' => Str::random(32),
            'app_key_aes_cbc' => Str::random(64),
            'app_key_aes_cbc_iv' => Str::random(64),
            'app_key_checksum' => Str::random(32)
        ]);
    }
}
