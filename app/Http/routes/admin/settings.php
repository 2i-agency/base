<?php

/*
 * Настройки
 */

Route::group([
	'prefix' => 'settings'
], function(){


	/*
	 * Сохранение настроек
	 */
	Route::put('save', [
		'uses' => 'SettingController@save',
		'as' => 'admin.settings.save'
	]);

	/*
	 * Раздел с настройками
	 */
	Route::get('{section?}', [
		'uses' => 'SettingController@section',
		'as' => 'admin.settings'
	]);

});
Route::controller('settings', 'SettingController', [
	'getIndex' => 'admin.settings'
]);