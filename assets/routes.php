<?php

/*
 * Админцентр
 */

Route::group([
	'prefix' => config('chunker.admin.prefix', 'admin'),
	'namespace' => 'Admin',
	'middleware' => ['admin']
], function () {

	$dir = __DIR__ . '/routes/admin';
	$files = array_slice(scandir($dir), 2);

	foreach ($files as $file) {
		require_once $dir . '/' . $file;
	}

});


/*
 * Сайт
 */

Route::group([
	'prefix' => '{language}',
	'namespace' => 'Site',
	'middleware' => ['web']
], function () {

	$dir = __DIR__ . '/routes/site';
	$files = array_slice(scandir($dir), 2);

	foreach ($files as $file) {
		require_once $dir . '/' . $file;
	}

});