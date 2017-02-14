<?php

/**
 * Группа роутов для работы с настройками
 */
Route::group([
	'prefix' => 'settings'
], function(){

	/**
	 * Раздел с настройками
	 *
	 * @var mixed|null $section модель/ключ раздела
	 */
	Route::get('{section?}', [
		'uses' => 'SettingController@section',
		'as'   => 'admin.settings'
	]);

	/**
	 * Сохранение настроек
	 */
	Route::put('save', [
		'uses' => 'SettingController@save',
		'as'   => 'admin.settings.save'
	]);

});