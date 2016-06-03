<?php

/*
 * Установка локали
 */

Route::get('set-locale/{locale}', [
	'as' => 'admin.set-locale',
	function($locale){
		session(['admin.locale' => $locale]);
		return redirect()->back();
	}
]);