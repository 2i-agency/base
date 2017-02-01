<?php

/**
 *
 */
Route::group([
	'prefix' => 'rights'
], function(){

	/**
	 *
	 */
	Route::post('/', [
		'uses' => 'RightsController@index',
		'as'   => 'admin.rights'
	]);

	/**
	 *
	 */
	Route::post('store', [
		'uses' => 'RightsController@store',
		'as'   => 'admin.rights.store'
	]);

	/**
	 *
	 */
	Route::post('update', [
		'uses' => 'RightsController@update',
		'as'   => 'admin.rights.update'
	]);

	/**
	 *
	 */
	Route::post('delete', [
		'uses' => 'RightsController@delete',
		'as'   => 'admin.rights.delete'
	]);


});