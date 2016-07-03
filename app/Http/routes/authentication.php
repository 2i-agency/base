<?php

/*
 * Аутентификация
 */

Route::group([
	'prefix'        => 'admin/auth',
	'namespace'     => 'Chunker\Base\Http\Controllers',
	'middleware'    => ['web']
], function () {

	// Аутентификация
	Route::post('login', [
		'uses'  => 'AuthController@login',
		'as'    => 'admin.login'
	]);

	// Деаутентификация
	Route::post('logout', [
		'uses'  => 'AuthController@logout',
		'as'    => 'admin.logout'
	]);

	// Форма сброса пароля
	Route::get('reset', [
		'uses'  => 'AuthController@showResetPasswordForm',
		'as'    => 'admin.reset-password-form'
	]);

	// Сброс пароля
	Route::post('reset', [
		'uses'  => 'AuthController@resetPassword',
		'as'    => 'admin.reset-password'
	]);

});