<?php

/*
 * Админцентр
 */

Route::group([
	'prefix' => config('chunker.admin.prefix', 'admin'),
	'namespace' => 'Chunker\Base\Http\Controllers',
	'middleware' => ['admin']
], function () {

	$files = [
		'languages',
		'translation',
		'set-locale',
		'users',
		'roles',
		'settings',
		'notices'
	];

	foreach ($files as $file) {
		require_once __DIR__ . '/admin/' . $file . '.php';
	}

});