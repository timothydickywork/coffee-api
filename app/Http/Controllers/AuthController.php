<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;

class AuthController extends Controller
{
	private function jwt($data)
	{
		$payload = [
			'iss' => env('JWT_ISSUER'),
			'sub' => [
				"id" => $data->id,
			],
			'iat' => time(),
			'exp' => time() + (60 * 60 * 24 * 30) // Expiration time
		];

		return JWT::encode($payload, env('JWT_SECRET'));
	}
}
