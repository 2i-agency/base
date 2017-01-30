<?php

/**
 * Группа роутов для работы с перенаправлениями
 */
Route::group([
	'prefix' => 'redirects'
], function(){

	/**
	 * Список перенаправлений
	 */
	Route::get('/', [
		'uses' => 'RedirectController@index',
		'as'   => 'admin.redirects'
	]);

	/**
	 * Добавление перенаправления
	 */
	Route::post('store', [
		'uses' => 'RedirectController@store',
		'as'   => 'admin.redirects.store'
	]);

	/**
	 * Сохранение перенаправлений
	 */
	Route::put('save', [
		'uses' => 'RedirectController@save',
		'as'   => 'admin.redirects.save'
	]);

	/**
	 * Сохранение типов
	 */
	Route::put('restore/{redirect}', [
		'uses' => 'RedirectController@restore',
		'as'   => 'admin.redirects.restore'
	]);

});