<?php

Route::group([
	'prefix' => 'activity'
], function(){

	Route::get('/', [
		'as'   => 'admin.activity-log',
		'uses' => 'ActivityLogController@index'
	]);
});