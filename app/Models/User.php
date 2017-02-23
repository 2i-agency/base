<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\IsRelatedWith;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Comparable;
use Auth;
use Illuminate\Database\Eloquent\Collection;
use Spatie\Activitylog\Traits\CausesActivity;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Модель пользователя
 *
 * @package Chunker\Base\Models
 */
class User extends Authenticatable
{
	use
		BelongsToEditors,
		Comparable,
		Nullable,
		IsRelatedWith,
		CausesActivity;

	/** @var string имя таблицы */
	public $table = 'base_users';

	protected static $ignoreChangedAttributes = [
		'created_at',
		'updated_at',
		'creator_id',
		'updater_id',
		'remember_token'
	];

	/** @var array поля принимающие null */
	protected $nullable = [ 'name' ];

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'login',
		'password',
		'email',
		'name',
		'is_subscribed',
		'is_blocked',
		'is_admin'
	];

	/** @var array поля, которые должны быть скрыты при преобразовании модели в массив */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/** @var array поля для мутаторов */
	protected $casts = [
		'is_subscribed' => 'boolean',
		'is_blocked'    => true,
		'is_admin'      => false
	];


	/**
	 * Проверяем возможности у моделей
	 *
	 * @param      $ability
	 * @param null $models
	 *
	 * @return bool
	 */
	protected function hasAccessModels($ability, $models = NULL) {
		/** Если передана модель или коллекция моделей */
		if (!is_null($models)) {

			/** Если передана одна модель, оборачиаем её в коллекцию, для удобства */
			if ($models instanceof Model) {
				$models = ( new Collection() )->add($models);
			}

			/** Проходимся по всем переданным моделям */
			foreach ($models as $model) {

				if (
					( $model instanceof User )
					&& $model->id == \Auth::user()->id
				) {
					return true;
				}

				/** TODO Нужно лучше продумать логику проверки по родителям, с учётом настроек самого ребёнка */
				if (method_exists($model, 'newNestedSetQuery')) {
					$result_ancestors = $this->hasAccessModels($ability, $model->getAncestors());
					if ($result_ancestors) {
						return true;
					}
				}

				/** Если у модели есть связь с агентами */
				if (method_exists($model, 'agents')) {
					$abilities = $model
						->agents()
						->whereIn('id', $this
							->agents()
							->pluck('id')
							->toArray()
						)
						->pluck('ability_id')
						->toArray();

					/** Проверяем все связанные возможности */
					foreach ($abilities as $value) {

						if (is_null($value)) {
							return NULL;
						}

						/** Пространство имён проверяемой и переданной совпадают */
						if (Ability::detectNamespace($value) == Ability::detectNamespace($ability)) {

							/** Приоритет проверямеой выше чем переданной */
							if (Ability::getPriority($value, $ability)) {
								return true;
							}

						}
					}
				}

			}
		}

		return false;
	}


	/**
	 * Возможности
	 */
	public function abilities() {
		return $this->morphToMany(Ability::class, 'model', 'base_abilities_roles_users');
	}


	public function notices() {
		return $this->belongsToMany(Notice::class, 'base_notices_users');
	}


	/**
	 * Типы уведомлений
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function noticesTypes() {
		return $this->morphToMany(NoticesType::class, 'model', 'base_notices_type_role_user');
	}


	/**
	 * Аутентификации
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function authentications() {
		return $this->hasMany(Authentication::class);
	}


	/**
	 * Роли
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles() {
		return $this->belongsToMany(Role::class, 'base_roles_users');
	}

	/**
	 * Агенты
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function agents() {
		return $this->morphMany(Agent::class, 'agent');
	}


	/**
	 * Хеширование пароля
	 *
	 * @param string $password
	 */
	public function setPasswordAttribute($password) {
		if (strlen($password)) {
			$this->attributes[ 'password' ] = bcrypt($password);
		}
	}


	/**
	 * Получения имени пользователя.
	 * Если для пользователя не задано имя, то возвращается логин
	 *
	 * @return string
	 */
	public function getName() {
		return is_null($this->name) ? $this->login : $this->name;
	}


	/**
	 * Можно ли сменить доступ в админ-центр (пользователь не может отключить сам себя)
	 *
	 * @return bool
	 */
	public function isCanBeAdminChanged() {
		return !$this->is(Auth::user());
	}


	/**
	 * Можно ли заблокировать пользователя (пользователь не может заблокировать сам себя).
	 *
	 * @return bool
	 */
	public function isCanBeBlocked() {
		return !$this->is(Auth::user());
	}


	/**
	 * Проверка доступа
	 *
	 * @param      $abilityNamespace
	 * @param bool $with_agents
	 *
	 * @return bool
	 */
	public function hasAccess($abilityNamespace, $with_agents = true) {

		/** Пользователь с id = 1 имеет доступ везде */
		if ($this->id == 1) {
			return true;
		}

		/** Если есть связь хотя бы с одной возможностью из пространства имён */
		if (
		$this
			->abilities()
			->where('id', 'LIKE', '%' . Ability::detectNamespace($abilityNamespace) . '.%')
			->count()
		) {
			return true;
		}

		/** Если есть агент с возможностью из пространства имён */
		if (
			$with_agents
			&& $this
				->agents()
				->where('ability_id', 'LIKE', '%' . Ability::detectNamespace($abilityNamespace) . '.%')
				->count()
		) {
			return true;
		}

		/** Проверяем доступ у ролей, привязанных к пользователю */
		foreach ($this->roles()->get([ 'id' ]) as $role) {
			if ($role->hasAccess($abilityNamespace)) {
				return true;
			}
		}

		/** В ином случае у пользователя нет доступа */
		return false;
	}

	/**
	 * Проверяет существование возможности у самомго пользователя
	 *
	 * @param      $ability
	 * @param null $models
	 *
	 * @return bool
	 */
	public function checkAbility($ability, $models = NULL) {

		/** Пользователь с id = 1 есть возможность */
		if ($this->id == 1) {
			return true;
		}

		/** Если у пользователя есть связь с возможностью */
		if ($this
				->abilities()
				->where('id', $ability)
				->count()
			&& !is_null($this->hasAccessModels($ability, $models))
		) {
			return true;
		}

		return false;
	}


	/**
	 * Проверка наличия возможности
	 *
	 * @param array|string          $ability возможности
	 * @param null|Model|Collection $models модель или коллекция моделей
	 *
	 * @return bool
	 */
	public function hasAbility($ability, $models = NULL) {

		if ($this->checkAbility($ability, $models)) {
			return true;
		}

		/** Проверяем возможности у моделей */
		$access_models = $this->hasAccessModels($ability, $models);

		/** У модели доступ закрыт */
		if (is_null($access_models)) {
			return false;
		}

		/** Если есть связи с другими возможностями из этого пространства имён */
		if ($this->hasAccess($ability)) {

			/** Проверяем все связанные возможности */
			foreach ($this->abilities()->pluck('id') as $value) {

				/** Пространство имён проверяемой и переданной совпадают */
				if (Ability::detectNamespace($value) == Ability::detectNamespace($ability)) {

					/** Приоритет проверямеой выше чем переданной */
					if (Ability::getPriority($value, $ability)) {
						return true;
					}

				}
			}

		}

		/** Проверяем возможности у ролей связанных с пользователем */
		foreach ($this->roles()->get([ 'id' ]) as $role) {

			if ($role->hasAbility($ability)) {
				return true;
			}
		}

		/** Проверяем возможности у моделей */
		if ($access_models) {
			return true;
		}

		/** В ином случае у пользователя нет возможности */
		return false;
	}


	/**
	 * Переопределил стандартную функцию модели
	 *
	 * @param string $ability
	 * @param array  $arguments
	 *
	 * @return bool
	 */
	public function can($ability, $arguments = []) {
		return
			$this->id == 1
			|| $this->hasAbility($ability, $arguments)
			|| app(Gate::class)->forUser($this)->check($ability, $arguments);
	}


	/**
	 * Определение административных прав доступа
	 *
	 * @param mixed $abilities возможности
	 * @param null  $models
	 * @param bool  $and
	 *
	 * @return bool
	 */
	public function hasAdminAccess($abilities, $models = NULL, $and = true) {

		/** Пользователь с id = 1 администратор */
		if ($this->id == 1) {
			return true;
		}

		/** Если передана одна возможность, оборачиваем её в массив для удобства */
		if (!is_array($abilities)) {
			$abilities = [ $abilities ];
		}

		$return = $and;

		/** Проверяем все переданные возможности */
		foreach ($abilities as $ability) {
			$admin_ability = Ability::getAdminAbility($ability);

			if ($and) {
				$return = $return && $this->hasAbility($admin_ability, $models);
			} else {
				$return = $return || $this->hasAbility($admin_ability, $models);
			}
		}

		return $return;
	}


	/**
	 * Заготовка запроса для исключения пользователя с id = 1 если запрашивает не он
	 *
	 * @param Builder $query
	 *
	 * @return Builder
	 */
	public function ScopeIsRootAdmin($query) {

		if (\Auth::user()->id == 1) {
			return $query;
		}

		return $query->where('id', '<>', 1);
	}


	/**
	 * Проверка статуса администратора
	 *
	 * @return bool
	 */
	public function isAdmin() {
		return $this->id == 1 || $this->is_admin;
	}

}