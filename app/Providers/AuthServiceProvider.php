<?php

namespace App\Providers;

use App\Models\Self\Customer;
use Firebase\JWT\JWT;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        $this->app['auth']->viaRequest('api', function ($request) {
            $token = $request->header('authorization');

            $bearer =  'Bearer';

            $tokenExplode = explode(" ", $token);

            if (count($tokenExplode) > 1) {
                $token = $tokenExplode[1];

                try {
                    $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
                } catch (Exception $e) {
                    throw new Exception("invalid_token_provided");
                }

                $sub = $credentials->sub;

                $u = Customer::find($sub->id);

                if ($u == null) {
                    throw new Exception("invalid_token_on_provider");
                }

                return $u;
            }
        });
    }
}
