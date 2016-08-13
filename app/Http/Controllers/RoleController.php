<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Request;
use Chunker\Base\Http\Requests\RoleRequest;
use Chunker\Base\Models\Role;

class RoleController extends Controller
{
	/*
	 * Страница роли
	 */
	public function form(Role $role = NULL) {
		// Роли
		$_roles = Role
			::orderBy('name')
			->get();


		// Представления возможностей
		$abilities_views = [];

		foreach (app()['Packages']->getPackages() as $package) {
			$abilities_views = array_merge($abilities_views, $package->getAbilitiesViews());
		}


		return view('chunker.base::admin.roles.form', compact('role', '_roles', 'abilities_views'));
	}


	/*
	 * Добавление роли
	 */
	public function store(RoleRequest $request) {
		$role = Role::create($request->all());
		$this->syncAbilities($request, $role);
		flash()->success('Роль <b>' . $role->name . '</b> добавлена');

		return redirect()->route('admin.roles', $role);
	}


	/*
	 * Обновление роли
	 */
	public function update(RoleRequest $request, Role $role) {
		$role->update($request->all());
		$this->syncAbilities($request, $role);
		flash()->success('Данные роли <b>' . $role->name . '</b> сохранены');

		return back();
	}


	/*
	 * Удаление роли
	 */
	public function destroy(Role $role) {
		$role->delete();
		flash()->warning('Роль <b>' . $role->name . '</b> удалена');

		return redirect()->route('admin.roles');
	}


	/*
	 * Синхронизация возможностей
	 */
	protected function syncAbilities(Request $request, Role $role) {
		if ($request->has('abilities')) {
			$abilities = [];

			foreach ($request->get('abilities') as $namespace => $ability) {
				// Отсев невозможного
				if ($ability) {
					$abilities[] = $ability;
				}

				// Синхронизация
				$role
					->abilities()
					->sync($abilities);
			}
		}
	}
}