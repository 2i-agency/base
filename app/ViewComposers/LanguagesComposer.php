<?php

namespace Chunker\Base\ViewComposers;

use Chunker\Base\Models\Language;
use Illuminate\View\View;

class LanguagesComposer
{
	public function compose(View $view) {
		$languages = Language
			::defaultOrder()
			->get(['id', 'name', 'locale']);

		$view->with('_languages', $languages);
	}
}