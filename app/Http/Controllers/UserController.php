<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Models\Role;
use Chunker\Base\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	protected $rules = [
		'login' => 'required|alpha_dash|max:20|unique:base_users,login',
		'password' => 'sometimes|min:6',
		'email' => 'required|email|unique:base_users,email'
	];


	public function __construct(Request $request) {
		// Приведение логина в требуемый вид
		$data = $request->all();

		if (isset($data['login'])) {
			$data['login'] = trim(str_slug($data['login']), '-_');
			$request->replace($data);
		}
	}


	/*
	 * Список пользователей
	 */
	public function index() {
		$this->authorize('users.view');

		$users = User
			::latest()
			->paginate();

		return view('chunker.base::admin.users.list', compact('users'));
	}


	/*
	 * Страница добавления пользователя
	 */
	public function create() {
		$this->authorize('users.edit');
		return view('chunker.base::admin.users.create');
	}


	/*
	 * Добавление пользователя
	 */
	public function store(Request $request) {
		$this->authorize('users.edit');

		// Валидация
		$this->validate($request, $this->rules);

		// Добавление
		$user = User::create($request->only([
			'login',
			'password',
			'email',
			'name',
			'is_subscribed',
			'is_blocked'
		]));

		// Сохранение связей
		$user->roles()->sync($request->get('roles', []));

		// Уведомление
		flash()->success('Пользователь <b>' . e($user->login) . '</b> добавлен');


		return redirect()->route('admin.users.edit', $user);
	}


	/*
	 * Страница редактирования пользователя
	 */
	public function edit(User $user) {
		$this->authorize('users.view', $user);
		return view('chunker.base::admin.users.edit', compact('user'));
	}


	/*
	 * Обновление пользователя
	 */
	public function update(Request $request, User $user) {
		$this->authorize('users.edit', $user);

		// Подготовка правил
		$this->rules['login'] .= ',' . $user->id;
		$this->rules['email'] .= ',' . $user->id;

		// Валидация
		$this->validate($request, $this->rules);

		// Подготовка данных
		$data = $request->only([
			'login',
			'password',
			'email',
			'name',
			'is_subscribed',
			'is_blocked'
		]);
		$data['is_blocked'] = $user->isCanBeBlocked() ? $data['is_blocked'] : false;

		// Обновление
		$user->update($data);

		// Сохранение связей
		$user->roles()->sync($request->get('roles', []));

		// Уведомление
		flash()->success('Данные пользователя <b>' . e($user->login) . '</b> сохранены');


		return back();
	}


	/*
	 * Список аутентификаций пользователя
	 */
	public function authentications(User $user) {
		$this->authorize('users.view', $user);

		$authentications = $user
			->authentications()
			->recent()
			->paginate();

		return view('chunker.base::admin.users.authentications', compact('user', 'authentications'));
	}
}