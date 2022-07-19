<?php

namespace Chunker\Base\Http\Controllers;

use Carbon\Carbon;
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
		'password' => 'sometimes|min:6'
	];


	public function __construct(Request $request){
		/** Приведение логина в требуемый вид */
		$data = $request->all();

		if (isset($data[ 'login' ])) {
			$data[ 'login' ] = trim(str_slug($data[ 'login' ]), '-_');
			$request->replace($data);
		}
	}


	protected function prepareEmails(string $emails):array {
		$request_emails = explode(PHP_EOL, $emails);
		$emails = [];

		foreach ($request_emails as $email) {
			$email = trim($email);

			if(mb_strlen($email)) {
				$emails[] = $email;
			}
		}

		return $emails;
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

		$data = $request->all();
		$data['emails'] = $this->prepareEmails($data['emails']);

		/** Создание объекта */
		$user = User::create($data);

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

		/** Валидация */
		$this->validate($request, $this->rules);

		/** Подготовка данных */
		$data = $request->all();
		$data[ 'is_blocked' ] = $user->isCanBeBlocked() ? $data[ 'is_blocked' ] : false;
		$data[ 'is_admin' ] = $user->isCanBeAdminChanged() ? $data[ 'is_admin' ] : $user->isAdmin();
		$data['emails'] = $this->prepareEmails($data['emails']);

		/** Обновление */
		$user->update($data);

		flash()->success('Данные пользователя <b>' . e($user->login) . '</b> сохранены');

		return back();
	}


	public function delete(User $user) {
		if(User::count() == 1) {
			flash()->error('Вы не можете удалить единственного пользователя.');

			return back();
		}

		$user->delete();

		return redirect()->route('admin.users');
	}


	/**
	 * Лог аутентификаций пользователя
	 *
	 * @param Request $request
	 * @param User    $user
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function activityLog(Request $request, User $user){
		$this->authorize('users.view', $user);

		$activities = $user->activity();

		if (isset($request->published_since) && $request->published_since != '') {
			$activities = $activities->where('created_at', '>=', Carbon::parse($request->published_since));
		}

		if (isset($request->published_until) && $request->published_until != '') {
			$activities = $activities->where('created_at', '<=', Carbon::parse($request->published_until));
		}

		if (isset($request->log_name) && $request->log_name != '') {
			$activities = $activities->where('log_name', $request->log_name);
		}

		if (isset($request->element) && $request->element != '') {
			$activities = $activities->where('subject_type', $request->element);
		}

		$activities = $activities->orderBy('id', 'desc')->paginate(30);

		return view(
			'base::users.activity-log',
			compact('user', 'activities')
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
		array_forget($packages_abilities_views, 'front');

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
				if ($ability && \Auth::user()->hasAdminAccess($namespace)) {
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