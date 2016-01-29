<?php

/*
 * Авторизация
 */

Route::group([
	'prefix' => 'auth',
	'namespace' => 'Chunker\Base\Controllers',
	'middleware' => ['web']
], function(){

	// Login
	Route::post('login', [
		'uses' => 'AuthController@login',
		'as' => 'login'
	]);

	// Logout
	Route::post('logout', [
		'uses' => 'AuthController@logout',
		'as' => 'logout'
	]);

});