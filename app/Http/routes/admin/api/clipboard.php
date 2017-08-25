<?php
Route::group([
	'prefix' => 'clipboard'
], function(){


	Route::post('/', [
		'uses' => 'ClipboardController@routes',
		'as'   => 'admin.clipboard.routes'
	]);


	Route::post('cut', [
		'uses' => 'ClipboardController@cut',
		'as'   => 'admin.clipboard.cut'
	]);


	Route::post('paste', [
		'uses' => 'ClipboardController@paste',
		'as'   => 'admin.clipboard.paste'
	]);


	Route::post('status', [
		'uses' => 'ClipboardController@status',
		'as'   => 'admin.clipboard.status'
	]);


	Route::post('clear', [
		'uses' => 'ClipboardController@clear',
		'as'   => 'admin.clipboard.clear'
	]);


	Route::post('clear-all', [
		'uses' => 'ClipboardController@clearAll',
		'as'   => 'admin.clipboard.clear-all'
	]);


});