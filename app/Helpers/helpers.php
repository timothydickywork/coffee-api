<?php

use App\Models\Self\SetupPoints;
use App\Models\Self\Customer;
use Carbon\Carbon;

if (!function_exists('config_path')) {
    function config_path($path = '')
    {
        return app()->basePath() . '/config' . ($path ? '/' . $path : $path);
    }
}

if (!function_exists('get_current_setup_points')) {
    function get_current_setup_points()
    {
        $now = Carbon::now()->isoFormat('YYYY-MM-DD');
        return SetupPoints::select(['id', 'min_transaction', 'start_date', 'expiration_day'])
            ->where('start_date', '<', $now)->orderBy('id', 'desc')->first();
    }
}

if (!function_exists('generate_code_customer')) {
    function generate_code_customer()
    {
        $now = Carbon::now();
        $arrCode = [
            'J', 'F', 'M', 'A', 'E', 'N', 'L', 'G', 'P', 'O', 'V', 'D'
        ];
        $currentCode = $arrCode[((int) $now->month) - 1];
        $characters = '0123456789';
        $charactersLength = strlen($characters);
        $randomString = '';
        do {
            $randomString = '';
            for ($i = 0; $i < 10; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            $exists = Customer::where('code', $currentCode . '-' . $randomString)->first();
        } while ($exists);
        return $currentCode . '-' . $randomString;
    }
}
