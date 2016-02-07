<?php

/*
 * Перевод интерфеса
 */

Route::group([
	'prefix' => 'translation'
], function(){

	// TODO Добавить перевод интерфейса
	Route::get('{section?}', [
		'uses' => 'TranslationController@index',
		'as' => 'admin.translation'
	]);

});