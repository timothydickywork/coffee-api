<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AppKeyTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(StoreTableSeeder::class);
        $this->call(SetupPointsTableSeeder::class);
    }
}
