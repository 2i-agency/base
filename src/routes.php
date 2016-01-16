<?php

Route::group([
	'prefix' => 'admin',
	'namespace' => 'Chunker\Admin\Controllers'
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

	});

});