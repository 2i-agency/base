<?php

/*
 * Установка локали
 */

Route::get('set-locale/{locale}', [
	'as' => 'admin.set-locale',
	function ($locale) {
		$language = \Chunker\Base\Models\Language::where('locale', $locale)->first();

		session([
			'admin.locale'      => $locale,
			'admin.language'    => $language
		]);

		return back();
	}
]);