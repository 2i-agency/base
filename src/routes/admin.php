<?php

/*
 * Админцентр
 */

Route::group([
	'prefix' => 'admin',
	'namespace' => 'Chunker\Base\Controllers',
	'middleware' => ['admin']
], function(){

	$files = [
		'assets',
		'dashboard',
		'users'
	];

	foreach ($files as $file)
	{
		require_once __DIR__ . '/admin/' . $file . '.php';
	}

});