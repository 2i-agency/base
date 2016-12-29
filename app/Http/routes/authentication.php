<?php

/**
 * Группа роутов для аутентификации
 */
Route::group([
	'prefix'     => config('chunker.admin.prefix', 'admin') . '/auth',
	'namespace'  => 'Chunker\Base\Http\Controllers',
	'middleware' => [ 'web' ]
], function(){

	/**
	 * Аутентификация
	 */
	Route::post('login', [
		'uses' => 'AuthenticationController@login',
		'as'   => 'admin.login'
	]);

	/**
	 * Деаутентификация
	 */
	Route::post('logout', [
		'uses' => 'AuthenticationController@logout',
		'as'   => 'admin.logout'
	]);

	/**
	 * Группа роутов для сброса пароля
	 */
	Route::group([
		'middleware' => 'guest'
	], function(){

		/**
		 * Форма сброса пароля
		 */
		Route::get('reset', [
			'uses' => 'AuthenticationController@showResetPasswordForm',
			'as'   => 'admin.reset-password-form'
		]);

		/**
		 * Сброс пароля
		 */
		Route::post('reset', [
			'uses' => 'AuthenticationController@resetPassword',
			'as'   => 'admin.reset-password'
		]);

	});

});