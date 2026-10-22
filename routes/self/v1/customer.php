<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
	'middleware' => 'api.throttle',
	'limit' => 60,
	'expires' => 1
], function ($api) {
	$api->group([
		'namespace' => 'App\Http\Controllers\Self',
		'prefix' => 'customer',
		'middleware' => [
			// "key",
		],
	], function ($api) {
		$api->group([
			'middleware' => [
				// "checksum",
				// "hash"
			],
		], function ($api) {
			$api->get('/list', 'CustomerController@index');
			$api->post('/login/password', 'CustomerController@loginPassword');
			$api->post('/login/uid', 'CustomerController@loginUid');
			$api->post('/register', 'CustomerController@register');
			$api->post('/change-password', 'CustomerController@changePassword');
			$api->post('/reset-password', 'CustomerController@resetPassword');
			$api->put('/{code}', 'CustomerController@update');
		});
	});
});
