<?php

Route::group([
	'prefix' => 'activity'
], function(){

	Route::match([
			'get', 'post'
		],
		'/', [
		'as'   => 'admin.activity-log',
		'uses' => 'ActivityLogController@index'
	]);
});