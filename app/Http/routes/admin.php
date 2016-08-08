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
		'redirects',
		'settings',
		'notices',
		'notices-types'
	];

	foreach ($files as $file) {
		require_once __DIR__ . '/admin/' . $file . '.php';
	}

});