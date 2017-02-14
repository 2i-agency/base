<?php

namespace Chunker\Base\ViewComposers;

use Chunker\Base\Models\Language;
use Illuminate\View\View;

/**
 * В представление передаётся переменная $_language
 * хранящая в себе модель текущей локали
 *
 * @package Chunker\Base\ViewComposers
 */
class LanguagesComposer
{
	public function compose(View $view){
		$languages = Language
			::defaultOrder()
			->get([ 'id', 'name', 'locale' ]);

		$view->with('_languages', $languages);
	}
}