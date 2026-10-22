<?php

namespace App\Http\Middleware;

use App\Exceptions\UnAuthorizedException;
use Closure;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class Authenticate
{
    protected $auth;

    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('authorization');

        if (!$token) {
            throw new UnAuthorizedException("bearer_token_not_provided");
        }

        $token = trim(str_replace("Bearer", "", $token));

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $e) {
            throw new UnAuthorizedException("bearer_token_expired");
        } catch (Exception $e) {
            throw new UnAuthorizedException("invalid_bearer_token");
        }


        return $next($request);
    }
}
