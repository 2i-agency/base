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
		'dashboard',
		'languages',
		'translation',
		'set-locale',
		'users',
		'settings'
	];

	foreach ($files as $file) {
		require_once __DIR__ . '/admin/' . $file . '.php';
	}

});