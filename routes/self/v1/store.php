<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
	'middleware' => 'api.throttle',
	'limit' => 60,
	'expires' => 1
], function ($api) {
	$api->group([
		'namespace' => 'App\Http\Controllers\Self',
		'prefix' => 'store',
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
			$api->get('/list', 'StoreController@index');
			$api->delete('/{id}', 'StoreController@delete');
			$api->post('', 'StoreController@store');
			$api->put('/{id}', 'StoreController@update');
		});
	});
});
