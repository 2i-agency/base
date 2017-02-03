<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Http\Controllers\Traits\AbilitiesLists;
use Chunker\Base\Models\NoticesType;
use Chunker\Base\Models\Role;
use Chunker\Base\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
	use AbilitiesLists;

	/** @var array массив правил для валидации */
	protected $rules = [
		'login'    => 'required|alpha_dash|max:20|unique:base_users,login',
		'password' => 'sometimes|min:6',
		'email'    => 'required|email|unique:base_users,email'
	];


	public function __construct(Request $request){
		/** Приведение логина в требуемый вид */
		$data = $request->all();

		if (isset($data[ 'login' ])) {
			$data[ 'login' ] = trim(str_slug($data[ 'login' ]), '-_');
			$request->replace($data);
		}
	}


	/**
	 * Список пользователей
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(){
		$this->authorize('users.view');
		$users = User::latest();

		/** Убираем супер-администратора из списка, если если авторизированный пользователь не он */
		if (\Auth::user()->id != 1) {
			$users->where('id', '<>', 1);
		}

		$users = $users->paginate();
		return view('base::users.list', compact('users'));
	}


	/**
	 * Страница добавления пользователя
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function create(){
		$this->authorize('users.edit');
		return view('base::users.create');
	}


	/**
	 * Добавление пользователя
	 *
	 * @param Request $request
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(Request $request){
		$this->authorize('users.edit');

		/** Валидация */
		$this->validate($request, $this->rules);

		/** Создание объекта */
		$user = User::create($request->only([
			'login',
			'password',
			'email',
			'name',
			'is_subscribed',
			'is_blocked',
			'is_admin'
		]));

		/** Сохранение связей */
		$user->roles()->sync($request->get('roles', []));

		flash()->success('Пользователь <b>' . e($user->login) . '</b> добавлен');

		return redirect()->route('admin.users.edit', $user);
	}


	/**
	 * Страница редактирования пользователя
	 *
	 * @param User $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function edit(User $user){
		$this->authorize('users.view', $user);
		return view('base::users.edit', compact('user'));
	}


	/**
	 * Обновление пользователя
	 *
	 * @param Request $request
	 * @param User    $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function update(Request $request, User $user){
		$this->authorize('users.edit', $user);

		/** Подготовка правил. Добавление ключа модели в правила */
		$this->rules[ 'login' ] .= ',' . $user->id;
		$this->rules[ 'email' ] .= ',' . $user->id;

		/** Валидация */
		$this->validate($request, $this->rules);

		/** Подготовка данных */
		$data = $request->only([
			'login',
			'password',
			'email',
			'name',
			'is_subscribed',
			'is_blocked',
			'is_admin'
		]);
		$data[ 'is_blocked' ] = $user->isCanBeBlocked() ? $data[ 'is_blocked' ] : false;
		$data[ 'is_admin' ] = $user->isCanBeAdminChanged() ? $data[ 'is_admin' ] : $user->isAdmin();

		/** Обновление */
		$user->update($data);

		/** Сохранение связей */
		$user->roles()->sync($request->get('roles', []));

		flash()->success('Данные пользователя <b>' . e($user->login) . '</b> сохранены');

		return back();
	}


	/**
	 * Лог аутентификаций пользователя
	 *
	 * @param User $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function authentications(User $user){
		$this->authorize('users.view', $user);

		$authentications = $user
			->authentications()
			->recent()
			->paginate();

		return view(
			'base::users.authentications',
			compact('user', 'authentications')
		);
	}



	public function abilities(User $user){
		$this->authorize('users.view', $user);

		/** Если пользователь не может редактировать, то и создавать не может */
		if (false) {
			return redirect()->route('admin.roles', Role::orderBy('name')->first());
		}

		$agent = $user;

		/** Коллекция ролей */
		$_roles = Role::orderBy('name')->get([ 'id', 'name' ]);

		/** Коллекция типов уведомлений */
		$notices_types = NoticesType::orderBy('name')->get([ 'id', 'name' ]);

		/** Представления возможностей */
		$packages_abilities_views = [];

		foreach (app()[ 'Packages' ]->getPackages() as $key => $package) {
			$packages_abilities_views[$key] = $package->getAbilitiesViews();
		}

		return view(
			'base::users.abilities',
			compact('user', 'agent', '_roles', 'packages_abilities_views', 'notices_types')
		);

	}


	/**
	 * Обновление возможностей пользователя
	 *
	 * @param Request $request
	 * @param User    $user
	 *
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function updateAbilities(Request $request, User $user){
		$this->authorize('users.edit', $user);

		if ($request->has('abilities')) {
			$abilities = [];

			/** Сбор в массив возможностей, которые разрешены пользователю */
			foreach ($request->get('abilities') as $namespace => $ability) {
				if ($ability && \Auth::user()->hasAdminAccess($namespace . '.edit')) {
					$abilities[] = $ability;
				}
			}

			/** Синхронизация возможностей с пользователем */
			$user->abilities()->sync($abilities);
		}

		/** Сохранение связей */
		$user->roles()->sync($request->get('roles', []));

		$user->noticesTypes()->sync($request->get('notices_types', []));

		flash()->success('Изменения сохранены');

		return back();
	}
}