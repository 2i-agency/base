<?php

/*
 * Главная страница админцентра
 */

Route::get('/', [
	'uses' => 'HomeController@index',
	'as' => 'admin.home'
]);