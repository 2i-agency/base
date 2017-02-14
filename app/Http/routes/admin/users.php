<?php

/**
 * Группа роутов для работы с пользователями
 */
Route::group([
	'prefix' => 'users'
], function(){

	/**
	 * Страница со списком пользователей
	 */
	Route::get('/', [
		'uses' => 'UserController@index',
		'as'   => 'admin.users'
	]);

	/**
	 * Страница с формой создания пользователя
	 */
	Route::get('create', [
		'uses' => 'UserController@create',
		'as'   => 'admin.users.create'
	]);

	/**
	 * Добавление пользователя
	 */
	Route::post('store', [
		'uses' => 'UserController@store',
		'as'   => 'admin.users.store'
	]);

	/**
	 * Группа роутов для манипуляций с пользователем
	 */
	Route::group([
		'prefix' => '{user}'
	], function(){

		/**
		 * Страница с формой редактирования пользователя
		 */
		Route::get('/', [
			'uses' => 'UserController@edit',
			'as'   => 'admin.users.edit'
		]);

		/**
		 * Обновление пользователя
		 */
		Route::put('update', [
			'uses' => 'UserController@update',
			'as'   => 'admin.users.update'
		]);

		/**
		 * Удаление пользователя
		 */
		Route::delete('destroy', [
			'uses' => 'UserController@destroy',
			'as'   => 'admin.users.destroy'
		]);

		/**
		 * Восстановление пользователя
		 */
		Route::get('restore', [
			'uses' => 'UserController@restore',
			'as'   => 'admin.users.restore'
		]);

		/**
		 * Страница со списком аутентификаций
		 */
		Route::match([
			'get', 'post'
		],
			'activity-log', [
			'uses' => 'UserController@activityLog',
			'as'   => 'admin.users.activity-log'
		]);

		/**
		 * Страница со списком возможностей
		 */
		Route::get('abilities', [
			'uses' => 'UserController@abilities',
			'as'   => 'admin.users.abilities'
		]);

		/**
		 * Страница со списком возможностей
		 */
		Route::put('update-abilities', [
			'uses' => 'UserController@updateAbilities',
			'as'   => 'admin.users.update-abilities'
		]);

	});

});