<?php

/*
 * Контрольная панель админцентра
 */

Route::get('/', [
	'uses' => 'DashboardController@index',
	'as' => 'admin.dashboard'
]);