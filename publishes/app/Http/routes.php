<?php

/**
 * Группа роутов для сайта
 *
 * @var mixed $language модель/ключ локали
 */
Route::group([
	'prefix'     => config('chunker.localization.multi') ? '{language}' : NULL,
	'namespace'  => 'Site',
	'middleware' => [ 'web' ]
], function() {
	/** Подключение роутов */
	require_routes(__DIR__ . '/routes/site/');
});

/**
 * Группа роутов для админпанели
 */
Route::group([
	'prefix'     => config('chunker.admin.prefix', 'admin'),
	'namespace'  => 'Admin',
	'middleware' => [ 'admin' ]
], function() {
	/** Подключение роутов */
	require_routes(__DIR__ . '/routes/admin/');
});