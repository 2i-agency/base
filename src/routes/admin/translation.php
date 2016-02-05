<?php

/*
 * Перевод интерфеса
 */

Route::group([
	'prefix' => 'translation'
], function(){

	Route::get('{section?}', [
		'uses' => 'TranslationController@index',
		'as' => 'admin.translation'
	]);

});