<?php

/**
 * Группа роутов для работы с языками
 */
Route::group([
	'prefix' => 'languages'
], function(){

	/**
	 * Список языков
	 */
	Route::get('/', [
		'uses' => 'LanguageController@index',
		'as'   => 'admin.languages'
	]);

	/**
	 * Добавление языка
	 */
	Route::post('store', [
		'uses' => 'LanguageController@store',
		'as'   => 'admin.languages.store'
	]);

	/**
	 * Обновление языка
	 *
	 * @var mixed $language модель/ключ языка
	 */
	Route::put('{language}', [
		'uses' => 'LanguageController@update',
		'as'   => 'admin.languages.update'
	]);

	/**
	 * Позиционирование языков
	 */
	Route::get('positioning', [
		'uses' => 'LanguageController@positioning',
		'as'   => 'admin.languages.positioning'
	]);

});