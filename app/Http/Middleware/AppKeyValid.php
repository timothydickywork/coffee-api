<?php

namespace App\Http\Middleware;

use App\Models\AppKey;
use Closure;

class AppKeyValid
{
    protected $auth;

    public function handle($request, Closure $next, $guard = null)
    {
        $app_key = AppKey::where("app_key_value", $request->header("x-app-key"))
            ->first();

        return $next($request);
    }
}
