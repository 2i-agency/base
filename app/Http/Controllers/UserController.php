<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Models\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Validator;

class UserController extends Controller
{
	protected $rules = [
		'login' => 'required|alpha_dash|max:20|unique:users,login',
		'password' => 'sometimes|min:6',
		'email' => 'required|email|unique:users,email'
	];


	public function __construct(Request $request) {
		// Приведение логина в требуемый вид
		$data = $request->all();
		if (isset($data['login']))
		{
			$data['login'] = trim(str_slug($data['login']), '-_');
			$request->replace($data);
		}
	}


	/*
	 * Список пользователей
	 */
	public function index() {
		$fields = ['id', 'login', 'email', 'name', 'deleted_at'];

		$users_query = User::orderBy('login');
		$active_users = $users_query->get($fields);
		$deleted_users = $users_query
			->onlyTrashed()
			->get($fields);

		return view('chunker.base::admin.users.list', compact('active_users', 'deleted_users'));
	}


	/*
	 * Страница добавления пользователя
	 */
	public function create() {
		return view('chunker.base::admin.users.create');
	}


	/*
	 * Добавление пользователя
	 */
	public function store(Request $request) {
		// Валидация
		$this->validate($request, $this->rules);

		// Добавление
		$user = User::create($request->only([
			'login',
			'password',
			'email',
			'name'
		]));

		// Уведомление
		flash()->success('Пользователь <b>' . $user->login . '</b> добавлен');


		return redirect()->route('admin.users.edit', $user);
	}


	/*
	 * Страница редактирования пользователя
	 */
	public function edit(User $user) {
		return view('chunker.base::admin.users.edit', compact('user'));
	}


	/*
	 * Обновление пользователя
	 */
	public function update(Request $request, User $user) {
		// Подготовка правил
		$rules = $this->rules;
		$rules['login'] .= ',' . $user->id;
		$rules['email'] .= ',' . $user->id;

		// Валидация
		$this->validate($request, $rules);

		// Обновление
		$user->update($request->only([
			'login',
			'password',
			'email',
			'name'
		]));

		// Уведомление
		flash()->success('Данные пользователя <b>' . $user->login . '</b> сохранены');


		return back();
	}


	/*
	 * Удаление пользователя
	 */
	public function destroy(User $user) {
		if ($user->isCanBeDeleted()) {
			$user->delete();
			flash()->warning('Пользователь <b>' . $user->login . '</b> удалён');
		}
		else
		{
			flash()->danger('Вы не можете удалить этого пользователя');
		}

		return redirect()->route('admin.users');
	}


	/*
	 * Восстановление пользователя
	 */
	public function restore($userId) {
		$user = User::withTrashed()->find($userId);
		$user->restore();
		flash()->success('Пользователь <b>' . $user->login . '</b> восстановлен');

		return redirect()->route('admin.users.edit', $user);
	}


	/*
	 * Список аутентификаций пользователя
	 */
	public function authentications(User $user) {
		$authentications = $user
			->authentications()
			->recent()
			->paginate();

		return view('chunker.base::admin.users.authentications', compact('user', 'authentications'));
	}
}