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

/**
 * Модель пользователя
 *
 * @package Chunker\Base\Models
 */
class User extends Authenticatable
{
	use BelongsToEditors, Comparable, Nullable, IsRelatedWith;

	/** @var string имя таблицы */
	public $table = 'base_users';

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
	 * Алиас для метода isCanBeBlocked.
	 *
	 * @return bool
	 */
	public function isCanBeAdminChanged() {
		return $this->isCanBeBlocked();
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
	 * @param string $abilityNamespace пространство имён возможности
	 *
	 * @return bool
	 */
	public function hasAccess($abilityNamespace) {
		if (
		$this
			->abilities()
			->where('id', 'LIKE', '%' . Ability::detectNamespace($abilityNamespace) . '.%')
			->count()
		) {
			/** Если есть связь хотя бы с одной возможностью из пространства имён */
			return true;
		} else {
			foreach ($this->roles()->get([ 'id' ]) as $role) {
				if ($role->hasAccess($abilityNamespace)) {
					return true;
				}
			}
		}

		return false;
	}


	/**
	 * Проверка наличия возможности
	 *
	 * @param array|string $ability возможности
	 *
	 * @return bool
	 */
	public function hasAbility($ability, $model = NULL) {

		if ($this->id == 1) {
			return true;
		}

		if (
			!is_null($model)
			&& ($model instanceof Model)
			&& ($model->creator_id == $this->id))
		{
			return true;
		}

		if ($this
			->abilities()
			->where('id', $ability)
			->count()
		) {
			return true;
		}

		/** Если есть связи с другими возможностями из этого пространства имён */
		if ($this->hasAccess($ability)) {
			foreach ($this->abilities()->pluck('id') as $value) {

				if (Ability::detectNamespace($value) == Ability::detectNamespace($ability)) {

					if (Ability::getPriority($value, $ability)) {
						return true;
					}

				}
			}

		}

		foreach ($this->roles()->get([ 'id' ]) as $role) {

			if ($role->hasAbility($ability)) {
				return true;
			}
		}

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
			|| $this->hasAdminAccess($ability)
			|| app(Gate::class)->forUser($this)->check($ability, $arguments);
	}


	/**
	 * Определение административных прав доступа
	 *
	 * @param array|string $abilities возможность
	 *
	 * @return bool
	 */
	public function hasAdminAccess($abilities, $model = NULL) {

		if (
			!is_null($model)
			&& ($model instanceof Model)
			&& isset($model->created_at)
			&& $model->creator_id == $this->id
		) {
			return true;
		}

		if ($this->id == 1) {
			return true;
		}

		if (!is_array($abilities)) {
			$abilities = [ $abilities ];
		}

		foreach ($abilities as $ability) {

			if ($this->hasAbility(Ability::detectNamespace($ability) . Ability::getAdminPostfix($ability, true))) {
				return true;
			}
		}

		return false;
	}


	public function ScopeIsRootAdmin(Builder $builder) {

		if (\Auth::user()->id == 1) {
			return $builder;
		}

		return $builder->where('id', '<>', 1);
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