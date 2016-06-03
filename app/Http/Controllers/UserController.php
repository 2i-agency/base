<?php

namespace Chunker\Base\Controllers;

use Chunker\Base\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	/*
	 * Список пользователей
	 */
	public function index()
	{
		$all_users = User::orderBy('login');
		$active_users = $all_users->get();
		$deleted_users = $all_users->onlyTrashed()->get();

		return view('Base::users.index', compact('active_users', 'deleted_users'));
	}


	/*
	 * Страница добавления пользователя
	 */
	public function create()
	{
		return view('Base::users.create');
	}


	/*
	 * Добавление пользователя
	 */
	public function store(Request $request)
	{
		$user = User::create($request->only([
			'login',
			'password',
			'email',
			'name'
		]));

		return redirect()->route('admin.users.edit', $user);
	}


	/*
	 * Страница редактирования пользователя
	 */
	public function edit(User $user)
	{
		return view('Base::users.edit', compact('user'));
	}


	/*
	 * Обновление пользователя
	 */
	public function update(Request $request, User $user)
	{
		$user->update($request->only([
			'login',
			'password',
			'email',
			'name'
		]));

		return redirect()->back();
	}


	/*
	 * Удаление пользователя
	 */
	public function destroy(User $user)
	{
		if ($user->isCanBeDeleted())
		{
			$user->delete();
		}

		return redirect()->route('admin.users');
	}


	/*
	 * Восстановление пользователя
	 */
	public function restore($userId)
	{
		$user = User::withTrashed()->find($userId);
		$user->restore();

		return redirect()->route('admin.users.edit', $user);
	}


	/*
	 * Список авторизаций пользователя
	 */
	public function authorizations(User $user)
	{
		$authorizations = $user
			->authorizations()
			->recent()
			->paginate();

		return view('Base::users.authorizations', compact('user', 'authorizations'));
	}
}