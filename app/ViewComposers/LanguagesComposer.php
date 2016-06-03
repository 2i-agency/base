<?php

namespace Chunker\Base\ViewComposers;

use Chunker\Base\Models\Language;
use Illuminate\View\View;

class LanguagesComposer
{
	public function compose(View $view)
	{
		$view->with('_languages', Language::positioned()->get(['id', 'name', 'route_key']));
	}
}