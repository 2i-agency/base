<?php

/*
 * Авторизация
 */

Route::group([
	'prefix' => 'auth',
	'namespace' => 'Chunker\Base\Http\Controllers',
	'middleware' => ['web']
], function(){

	// Аутентификация
	Route::post('login', [
		'uses' => 'AuthController@login',
		'as' => 'login'
	]);

	// Деаутентификация
	Route::post('logout', [
		'uses' => 'AuthController@logout',
		'as' => 'logout'
	]);

});