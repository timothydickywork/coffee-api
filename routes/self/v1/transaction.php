<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
	'middleware' => 'api.throttle',
	'limit' => 60,
	'expires' => 1
], function ($api) {
	$api->group([
		'namespace' => 'App\Http\Controllers\Self',
		'prefix' => 'transaction',
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
			$api->get('/list', 'TransactionController@index');
			$api->delete('/{id}', 'TransactionController@delete');
			$api->post('', 'TransactionController@store');
		});
	});
});
