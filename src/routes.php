<?php

/*
 * Authorization
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


/*
 * Admin sections
 */

Route::group([
	'prefix' => 'admin',
	'namespace' => 'Chunker\Base\Controllers',
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
			'as' => 'admin.notices.index'
		]);

	});


	/*
	 * Users
	 */

	Route::group([
		'prefix' => 'users'
	], function(){

		// List of users
		Route::get('/', [
			'uses' => 'UserController@index',
			'as' => 'admin.users.index'
		]);


		// Page of creating new user
		Route::get('create', [
			'uses' => 'UserController@create',
			'as' => 'admin.users.create'
		]);


		// Storing new user
		Route::post('create', [
			'uses' => 'UserController@store',
			'as' => 'admin.users.store'
		]);


		Route::group([
			'prefix' => '{user}'
		], function(){

			// Page of editing user
			Route::get('/', [
				'uses' => 'UserController@edit',
				'as' => 'admin.users.edit'
			]);


			// Updating user
			Route::put('/', [
				'uses' => 'UserController@update',
				'as' => 'admin.users.update'
			]);


			// Deleting user
			Route::delete('/', [
				'uses' => 'UserController@delete',
				'as' => 'admin.users.delete'
			]);


			// List of user's authorizations
			Route::get('authorizations', [
				'uses' => 'UserController@authorizations',
				'as' => 'admin.users.authorizations'
			]);

		});

	});

});