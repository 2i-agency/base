<?php

/*
 * Authorization
 */

Route::group([
	'prefix' => 'auth',
	'namespace' => 'Chunker\Admin\Controllers',
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


/*
 * Admin sections
 */

Route::group([
	'prefix' => 'admin',
	'namespace' => 'Chunker\Admin\Controllers',
	'middleware' => ['admin']
], function(){

	/*
	 * Assets
	 */

	Route::get('css/{filename}', 'AssetController@css');
	Route::get('js/{directory}/{filename}', 'AssetController@js');


	/*
	 * Notice
	 */

	Route::group([], function(){

		// Index
		Route::get('/', [
			'uses' => 'NoticeController@index',
			'as' => 'admin.notices'
		]);

	});


	/*
	 * Users
	 */

	Route::group([
		'prefix' => 'users'
	], function(){

		// Index
		Route::get('/', [
			'uses' => 'UserController@index',
			'as' => 'admin.users'
		]);


		// Profile
		Route::get('{user}', [
			'uses' => 'UserController@edit',
			'as' => 'admin.users.edit'
		]);

	});

});