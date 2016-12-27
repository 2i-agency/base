<?php

namespace Chunker\Base\ViewComposers;

use Chunker\Base\Models\Role;
use Illuminate\View\View;

/**
 * В представление передаётся переменная $_roles
 * хранящая в себе список всех ролей
 *
 * @package Chunker\Base\ViewComposers
 */
class RolesComposer
{
	public function compose(View $view){
		$_roles = Role
			::orderBy('name')
			->get([ 'id', 'name' ]);

		$view->with('_roles', $_roles);
	}
}