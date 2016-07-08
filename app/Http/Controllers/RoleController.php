<?php

namespace Chunker\Base\Http\Controllers;

use App\Http\Controllers\Controller;
use Chunker\Base\Http\Requests\RoleRequest;
use Chunker\Base\Models\Role;

class RoleController extends Controller
{
	/*
	 * Страница роли
	 */
	public function form(Role $role = NULL) {
		$_roles = Role
			::orderBy('name')
			->get();

		return view('chunker.base::admin.roles.form', compact('role', '_roles'));
	}


	/*
	 * Добавление роли
	 */
	public function store(RoleRequest $request) {
		$role = Role::create($request->all());
		flash()->success('Роль <b>' . $role->name . '</b> добавлена');

		return redirect()->route('admin.roles', $role);
	}


	/*
	 * Обновление роли
	 */
	public function update(RoleRequest $request, Role $role) {
		$role->update($request->all());
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
}