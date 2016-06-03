<?php

namespace Chunker\Base\Http\Controllers;

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

		return view('chunker.base::users.index', compact('active_users', 'deleted_users'));
	}


	/*
	 * Страница добавления пользователя
	 */
	public function create()
	{
		return view('chunker.base::users.create');
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
		return view('chunker.base::users.edit', compact('user'));
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
	 * Список аутентификаций пользователя
	 */
	public function authentications(User $user)
	{
		$authentications = $user
			->authentications()
			->recent()
			->paginate();

		return view('chunker.base::users.authentications', compact('user', 'authentications'));
	}
}