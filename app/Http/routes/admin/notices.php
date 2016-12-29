<?php
/**
 * Список роутов для уведомлений
 */


/**
 * Список уведомлений
 */
Route::get('/', [
	'as'   => 'admin.notices',
	'uses' => 'NoticeController@index'
]);

/**
 * Отметка прочтения уведомления
 *
 * @var mixed $notice модель/ключ уведомления
 */
Route::put('read-notice/{notice}', [
	'as'   => 'admin.notices.read',
	'uses' => 'NoticeController@read'
]);

/**
 * Удаление уведомления
 *
 * @var mixed $notice модель/ключ уведомления
 */
Route::delete('destroy-notice/{notice}', [
	'as'   => 'admin.notices.destroy',
	'uses' => 'NoticeController@destroy'
]);