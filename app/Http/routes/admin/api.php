<?php

/**
 * Подключение роутов для работы API админцентра
 */
Route::group([
	'prefix'     => 'api',
	'namespace'  => 'Api',
], function(){

	require_routes(__DIR__ . '/api/');

});