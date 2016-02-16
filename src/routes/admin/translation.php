<?php

/*
 * Перевод интерфеса
 */

Route::group([
	'prefix' => 'translation'
], function(){

	// Список разделов
	Route::get('/', [
		'uses' => 'TranslationController@index',
		'as' => 'admin.translation'
	]);


	Route::group([
		'prefix' => '{section}'
	], function(){

		// Список элементов интерфейса раздела
		Route::get('/', [
			'uses' => 'TranslationController@section',
			'as' => 'admin.translation.section'
		]);

		// Обновление перевода
		Route::put('/', [
			'uses' => 'TranslationController@save',
			'as' => 'admin.translation.save'
		]);

	});

});