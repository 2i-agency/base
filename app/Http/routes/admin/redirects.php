<?php

/*
 * Перенаправления
 */

Route::group([
	'prefix' => 'redirects'
], function() {

	// Список перенаправлений
	Route::get('/', [
		'uses'  => 'RedirectController@index',
		'as'    => 'admin.redirects'
	]);

	// Добавление перенаправления
	Route::post('store', [
		'uses'  => 'RedirectController@store',
		'as'    => 'admin.redirects.store'
	]);

	// Сохранение перенаправлений
	Route::put('save', [
		'uses'  => 'RedirectController@save',
		'as'    => 'admin.redirects.save'
	]);

});