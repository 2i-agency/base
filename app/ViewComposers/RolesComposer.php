<?php

namespace Chunker\Base\ViewComposers;

use Chunker\Base\Models\Role;
use Illuminate\View\View;

class RolesComposer
{
	public function compose(View $view) {
		$_roles = Role
			::orderBy('name')
			->get(['id', 'name']);

		$view->with('_roles', $_roles);
	}
}