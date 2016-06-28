<?php

/*
 * Уведомления
 */

// Список уведомлений
Route::get('/', [
	'as' => 'admin.notices',
	'uses' => 'NoticeController@index'
]);

// Отметка прочтения уведомления
Route::put('read-notice/{notice}', [
	'as' => 'admin.notices.read',
	'uses' => 'NoticeController@read'
]);

// Удаление уведомления
Route::delete('destroy-notice/{notice}', [
	'as' => 'admin.notices.destroy',
	'uses' => 'NoticeController@destroy'
]);