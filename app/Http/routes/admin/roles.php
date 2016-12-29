<?php

/**
 * Группа роутов для работы с ролями
 */
Route::group([
	'prefix' => 'roles'
], function(){

	/**
	 * Страница роли
	 *
	 * @var mixed|null $role модель/ключ роли
	 */
	Route::get('{role?}', [
		'uses' => 'RoleController@form',
		'as'   => 'admin.roles'
	]);

	/**
	 * Добавление роли
	 */
	Route::post('store', [
		'uses' => 'RoleController@store',
		'as'   => 'admin.roles.store'
	]);

	/**
	 * Группа роутов для редактирования роли
	 *
	 * @var mixed $role модель/ключ роли
	 */
	Route::group([
		'prefix' => '{role}'
	], function(){

		/**
		 * Обновление роли
		 */
		Route::put('update', [
			'uses' => 'RoleController@update',
			'as'   => 'admin.roles.update'
		]);

		/**
		 * Удаление роли
		 */
		Route::delete('destroy', [
			'uses' => 'RoleController@destroy',
			'as'   => 'admin.roles.destroy'
		]);

	});

});