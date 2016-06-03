<?php

/*
 * Пользователи
 */

Route::group([
	'prefix' => 'users'
], function(){

	// Страница со списком пользователей
	Route::get('/', [
		'uses' => 'UserController@index',
		'as' => 'admin.users'
	]);

	// Страница с формой создания пользователя
	Route::get('create', [
		'uses' => 'UserController@create',
		'as' => 'admin.users.create'
	]);

	// Добавление пользователя
	Route::post('store', [
		'uses' => 'UserController@store',
		'as' => 'admin.users.store'
	]);


	Route::group([
		'prefix' => '{user}'
	], function(){

		// Страница с формой редактирования пользователя
		Route::get('/', [
			'uses' => 'UserController@edit',
			'as' => 'admin.users.edit'
		]);

		// Обновление пользователя
		Route::put('update', [
			'uses' => 'UserController@update',
			'as' => 'admin.users.update'
		]);

		// Удаление пользователя
		Route::delete('destroy', [
			'uses' => 'UserController@destroy',
			'as' => 'admin.users.destroy'
		]);

		// Восстановление пользователя
		Route::get('restore', [
			'uses' => 'UserController@restore',
			'as' => 'admin.users.restore'
		]);

		// Страница со списком аутентификаций
		Route::get('authentications', [
			'uses' => 'UserController@authentications',
			'as' => 'admin.users.authentications'
		]);

	});

});