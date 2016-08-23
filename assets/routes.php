<?php

/*
 * Админцентр
 */

Route::group([
	'prefix' => config('chunker.admin.prefix', 'admin'),
	'namespace' => 'App\Http\Controllers\Admin',
	'middleware' => ['admin']
], function () {

	$files = [];

	foreach ($files as $file) {
		require_once __DIR__ . '/routes/admin/' . $file . '.php';
	}

});


/*
 * Сайт
 */

Route::get('/', function () {
	return view('welcome');
});