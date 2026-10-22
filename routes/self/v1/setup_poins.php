<?php
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', [
	'middleware' => 'api.throttle',
	'limit' => 60,
	'expires' => 1
], function ($api) {
	$api->group([
		'namespace' => 'App\Http\Controllers\Self',
		'prefix' => 'setup-points',
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
			$api->get('/now', 'SetupPointsController@now');
			$api->get('/future', 'SetupPointsController@future');
			$api->get('/history', 'SetupPointsController@history');
			$api->delete('/{id}', 'SetupPointsController@delete');
			$api->post('', 'SetupPointsController@store');
			$api->put('/{id}', 'SetupPointsController@update');
		});
	});
});
