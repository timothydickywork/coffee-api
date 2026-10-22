<?php

namespace Database\Seeders;

use App\Models\Self\Store;
use Illuminate\Database\Seeder;

class StoreTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::insert([
            'name' => "Sinaran",
            'kodepos_id' => 4234,
            'address' => "Jl. Sinaran no. 16",
            'latitude' => 14.268,
            'longitude' => 14.268,
            'phone' => "089646123876",
            'user_create' => "seeder"
        ]);
        Store::insert([
            'name' => "Cold & Brew",
            'kodepos_id' => 4232,
            'address' => "Jl. Dingin dan Menyeduh no. 26",
            'latitude' => 12.288,
            'longitude' => 145.128,
            'phone' => "089646123876",
            'user_create' => "seeder"
        ]);
    }
}
