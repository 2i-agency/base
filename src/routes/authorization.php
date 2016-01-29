<?php

/*
 * Авторизация
 */

Route::group([
	'prefix' => 'auth',
	'namespace' => 'Chunker\Base\Controllers',
	'middleware' => ['web']
], function(){

	// Авторизация
	Route::post('login', [
		'uses' => 'AuthController@login',
		'as' => 'login'
	]);

	// Деавторизация
	Route::post('logout', [
		'uses' => 'AuthController@logout',
		'as' => 'logout'
	]);

});