<?php

/*
 * Пользователи
 */

Route::group([
	'prefix' => 'roles'
], function () {

	// Страница роли
	Route::get('{role?}', [
		'uses'  => 'RoleController@form',
		'as'    => 'admin.roles'
	]);

	// Добавление роли
	Route::post('store', [
		'uses'  => 'RoleController@store',
		'as'    => 'admin.roles.store'
	]);


	Route::group([
		'prefix' => '{role}'
	], function() {

		// Обновление роли
		Route::put('update', [
			'uses' => 'RoleController@update',
			'as' => 'admin.roles.update'
		]);

		// Удаление роли
		Route::delete('destroy', [
			'uses' => 'RoleController@destroy',
			'as' => 'admin.roles.destroy'
		]);

	});

});