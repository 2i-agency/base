<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Http\Requests\RoleRequest;
use Chunker\Base\Models\NoticesType;
use Chunker\Base\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
	/**
	 * Синхронизация возможностей
	 *
	 * @param Request $request
	 * @param Role    $role
	 */
	protected function syncAbilities(Request $request, Role $role){
		if ($request->has('abilities')) {
			$abilities = [];

			/** Сбор в массив возможностей, которые разрешены пользователю */
			foreach ($request->get('abilities') as $namespace => $ability) {
				if ($ability && $request->user()->can($namespace . '.edit')) {
					$abilities[] = $ability;
				}
			}

			/** Синхронизация возможностей с пользователем */
			$role->abilities()->sync($abilities);
		}
	}


	/**
	 * Страница роли
	 *
	 * @param Request   $request
	 * @param Role|NULL $role
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
	 */
	public function form(Request $request, $role = NULL){

		if (is_int($role) || is_string($role)) {
			$role = Role::withDelete()->find($role);
		} elseif (is_null($role)) {
			$role = new Role();
		}

		$this->authorize('roles.view', $role);

		/** Если пользователь не может редактировать, то и создавать не может */
		if ($request->user()->cannot('roles.edit') && !$role->exists) {
			return redirect()->route('admin.roles', Role::orderBy('name')->first());
		}

		/** Коллекция ролей */
		$_roles = Role::orderBy('name')->withDelete()->get([ 'id', 'name' ]);

		$agent = $role;

		/** Коллекция типов уведомлений */
		$notices_types = NoticesType::orderBy('name')->get([ 'id', 'name' ]);

		/** Представления возможностей */
		$packages_abilities_views = [];

		foreach (app()[ 'Packages' ]->getPackages() as $key => $package) {
			$packages_abilities_views[$key] = array_merge($packages_abilities_views, $package->getAbilitiesViews());
		}

		return view(
			'base::roles.form',
			compact('role', 'agent', '_roles', 'packages_abilities_views', 'notices_types')
		);
	}


	/**
	 * Добавление роли
	 *
	 * @param RoleRequest $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(RoleRequest $request){
		$this->authorize('roles.edit');

		$role = Role::create($request->all());
		$this->syncAbilities($request, $role);
		$role->noticesTypes()->sync($request->get('notices_types', []));
		flash()->success('Роль <b>' . $role->name . '</b> добавлена');

		return redirect()->route('admin.roles', $role);
	}


	/**
	 * Обновление роли
	 *
	 * @param RoleRequest $request
	 * @param Role        $role
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(RoleRequest $request, Role $role){
		$this->authorize('roles.edit', $role);

		$role->update($request->all());
		$this->syncAbilities($request, $role);
		$role->noticesTypes()->sync($request->get('notices_types', []));
		flash()->success('Данные роли <b>' . $role->name . '</b> сохранены');

		return back();
	}


	/**
	 * Удаление роли
	 *
	 * @param Role $role
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function destroy(Role $role){
		$this->authorize('roles.edit', $role);

		$role->delete();
		flash()->warning('Роль <b>' . $role->name . '</b> удалена');

		return redirect()->route('admin.roles');
	}


	/**
	 * Восстановление роли
	 *
	 * @param Role $role
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function restore(Request $request){
		$this->authorize('roles.admin');

		$role = Role
			::withDelete()
			->find($request->role);

		$this->authorize('roles.admin', $role);

		$role->restore();

		flash()->success('Роль "' . $role->name . '" восстановлена');

		return back();
	}
}