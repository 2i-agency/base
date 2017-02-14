<?php

namespace Chunker\Base\ViewComposers;

use Illuminate\View\View;

/**
 * Указывает активен ли раздел с ролями
 *
 * @package Chunker\Base\ViewComposers
 */
class VisibleRoleComposer
{
	public function compose(View $view) {
		$role_active = false;

		foreach (config('chunker.admin.structure') as $parent) {

			if (isset($parent[ 'children' ])) {

				foreach ($parent[ 'children' ] as $child) {

					if (is_array($child) || ( $child != '' )) {
						if (is_string($child)) {
							$child = app('Packages')->getMenuItems()[ $child ];
						}

						if (!isset($child[ 'policy' ]) || \Auth::user()->can($child[ 'policy' ])) {
							if ($child[ 'route' ] == 'admin.roles') {
								$role_active = true;
								break 2;
							}
						}
					}

				}

			}

		}

		$view->with('_role_active', $role_active);
	}
}