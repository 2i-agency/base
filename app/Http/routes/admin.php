<?php

/*
 * Админцентр
 */

Route::group([
	'prefix' => 'admin',
	'namespace' => 'Chunker\Base\Http\Controllers',
	'middleware' => ['admin']
], function () {

	$files = [
		'languages',
		'translation',
		'set-locale',
		'dashboard',
		'users'
	];

	foreach ($files as $file) {
		require_once __DIR__ . '/admin/' . $file . '.php';
	}

});