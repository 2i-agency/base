<?php

namespace Chunker\Base\Http\Controllers;

use Chunker\Base\Models\Ability;
use Chunker\Base\Models\Agent;
use Chunker\Base\Models\Role;
use Chunker\Base\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RightsController extends Controller
{
	/**
	 * Возвращает административную возможность из пространства имён переданной
	 *
	 * @param $ability
	 *
	 * @return mixed|string
	 */
	protected function getAbility($ability) {
		$ability = array_first(explode('.', $ability));
		$ability .= Ability::getAdminPostfix($ability, true);

		return $ability;
	}


	/**
	 * Список пользователей
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function index(Request $request) {
		/** Создаём модель */
		$model = new $request->model;
		$model = $model->where($model->getRouteKeyName(), $request->id)->first();

		/** Проверяем доступ к модели */
		$this->authorize($this->getAbility($request->ability), $model);

		/** Фильтруем агентов, которые уже добавлены */
		$agents = $model->agents()->get();
		$exclude_agents = [
			'roles' => [],
			'users' => []
		];

		$foreach_agents = $agents;
		foreach ($foreach_agents as $key => $agent) {
			$exclude_agent = $agent->agentable()->first();

			if ($exclude_agent instanceof Role) {
				$exclude_agents['roles'][] = $exclude_agent->id;
			} elseif ($exclude_agent instanceof User) {
				$exclude_agents['users'][] = $exclude_agent->id;
			} elseif (is_null($exclude_agent)) {
				unset($agents[$key]);
			}

		}

		$roles = Role
			::whereNotIn('id', $exclude_agents['roles'])
			->get();
		$users = User
			::whereNotIn('id', $exclude_agents['users'])
			->isRootAdmin()
			->get();

		$ability = Ability::detectNamespace($request->ability);
		$postfixes = array_reverse(Ability::getPostfixes($ability));

		return view('base::utils.right.content', compact('postfixes', 'roles', 'users', 'agents', 'ability'));
	}


	public function store(Request $request) {
		$agent_class = Role::class;

		$model = new $request->model;
		$model = $model->where($model->getRouteKeyName(), $request->id)->first();

		$this->authorize($this->getAbility($request->ability), $model);

		$agent = $request->agent;
		if (array_first(explode(':', $agent)) == 'user') {
			$agent_class = User::class;
		}

		$agent = Agent::create([
			'ability_id' => $request->ability_agent,
			'agent_id'   => array_last(explode(':', $agent)),
			'agent_type' => $agent_class,
		]);

		$model->agents()->save($agent);

		return $this->index($request);
	}


	public function update(Request $request) {

		$model = new $request->model;
		$model = $model->where($model->getRouteKeyName(), $request->id)->first();

		$this->authorize($this->getAbility($request->ability), $model);

		Agent::find($request->agent)->update(['ability_id' => $request->ability_agent]);

		return $this->index($request);
	}


	public function delete(Request $request) {

		$model = new $request->model;
		$model = $model->where($model->getRouteKeyName(), $request->id)->first();

		$this->authorize($this->getAbility($request->ability), $model);

		Agent::destroy($request->agent);

		return $this->index($request);
	}
}