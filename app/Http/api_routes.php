<?php
	
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

	$api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
	$api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
	$api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
	$api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');

	// example of protected route
	$api->get('protected', ['middleware' => ['api.auth'], function () {		
		return \App\User::all();
    }]);

	// test route --ToDO Remove this route once in production
	$api->get('free', function() {
		return \App\User::all();
	});

	$api->group(['middleware' => 'api.auth'], function ($api) {
		$api->get('books', 'App\Api\V1\Controllers\BookController@index');
		$api->get('books/{id}', 'App\Api\V1\Controllers\BookController@show');
		$api->post('books', 'App\Api\V1\Controllers\BookController@store');
		$api->put('books/{id}', 'App\Api\V1\Controllers\BookController@update');
		$api->delete('books/{id}', 'App\Api\V1\Controllers\BookController@destroy');
		$api->get('getBooks/{limit}', 'App\Api\V1\Controllers\BookController@getAll');
	});
	$api->group(['middleware' => 'api.auth'], function ($api){
		$api->get('movie/{id}', 'App\Api\V1\Controllers\MovieController@show');
		$api->post('addMovie', 'App\Api\V1\Controllers\MovieController@addMovie');
		$api->get('getAll/{limit}', 'App\Api\V1\Controllers\MovieController@getAll');

		$api->get('torrent/{movieId}', 'App\Api\V1\Controllers\MovieController@getTorrent');

		$api->post('comment', 'App\Api\V1\Controllers\commentController@store');
		$api->get('comment/getAll/{movieId}','App\Api\V1\Controllers\commentController@getAll');
		$api->delete('comment/{id}', 'App\Api\V1\Controllers\commentController@destroy');

	});
});
