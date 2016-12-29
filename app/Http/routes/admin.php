<?php

/**
 * Подключение роутов для работы админцентра
 */
Route::group([
	'prefix'     => config('chunker.admin.prefix', 'admin'),
	'namespace'  => 'Chunker\Base\Http\Controllers',
	'middleware' => [ 'admin' ]
], function(){

	require_routes(__DIR__ . '/admin/');

});