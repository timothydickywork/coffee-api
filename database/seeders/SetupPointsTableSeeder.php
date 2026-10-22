<?php

namespace Database\Seeders;

use App\Models\Self\SetupPoints;
use Illuminate\Database\Seeder;

class SetupPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SetupPoints::insert([
            'min_transaction' => 10000,
            'start_date' => "2021-08-01",
            'expiration_day' => 365,
            'user_create' => "seeder"
        ]);
    }
}
