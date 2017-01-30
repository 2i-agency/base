<?php

/**
 * Группа роутов для работы с типами уведомлений
 */
Route::group([
	'prefix' => 'notices-types'
], function(){

	/**
	 * Список типов
	 */
	Route::get('/', [
		'uses' => 'NoticesTypeController@index',
		'as'   => 'admin.notices-types'
	]);

	/**
	 * Добавление типа
	 */
	Route::post('store', [
		'uses' => 'NoticesTypeController@store',
		'as'   => 'admin.notices-types.store'
	]);

	/**
	 * Сохранение типов
	 */
	Route::put('save', [
		'uses' => 'NoticesTypeController@save',
		'as'   => 'admin.notices-types.save'
	]);

	/**
	 * Сохранение типов
	 */
	Route::put('restore/{notices_type}', [
		'uses' => 'NoticesTypeController@restore',
		'as'   => 'admin.notices-types.restore'
	]);

});