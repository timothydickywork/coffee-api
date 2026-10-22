<?php

namespace Database\Seeders;

use App\Models\Self\Customer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class CustomerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Customer::insert([
            'code' => 'NonMember',
            'name' => "non-member",
            'email' => "-",
            'password' => Hash::make("non-member"),
            'uid' => "-"
        ]);
        Customer::insert([
            'code' => 'Melcosh001',
            'name' => "Timothy Dicky Herlambang",
            'email' => "timothydicky@gmail.com",
            'password' => Hash::make("dickydickydic"),
            'uid' => Str::random(32)
        ]);
    }
}
