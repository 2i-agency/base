<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\IsRelatedWith;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Comparable;
use Auth;

class User extends Authenticatable
{
	use BelongsToEditors, Comparable, Nullable, IsRelatedWith;

	public $table = 'base_users';

	protected $nullable = ['name'];

	protected $fillable = [
		'login',
		'password',
		'email',
		'name',
		'is_subscribed',
		'is_blocked'
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'is_subscribed' => 'boolean',
		'is_blocked' => true
	];


	/*
	 * Хеширование пароля
	 */
	public function setPasswordAttribute($password) {
		if (strlen($password)) {
			$this->attributes['password'] = bcrypt($password);
		}
	}


	/*
	 * Если для пользователя не задано имя, то возвращается логин
	 */
	public function getName() {
		return is_null($this->name) ? $this->login : $this->name;
	}


	/*
	 * Пользователь не может заблокировать сам себя
	 */
	public function isCanBeBlocked() {
		return !$this->is(Auth::user());
	}


	/*
	 * Аутентификации
	 */
	public function authentications() {
		return $this->hasMany(Authentication::class);
	}


	/*
	 * Роли
	 */
	public function roles() {
		return $this->belongsToMany(Role::class, 'base_role_user');
	}
	
	
	/*
	 * Проверка доступа
	 */
	public function isHasAccess($abilityNamespace) {
		foreach ($this->roles()->get('id') as $role) {
			if ($role->isHasAccess($abilityNamespace)) {
				return true;
			}
		}

		return false;
	}


	/*
	 * Проверка наличия возможности
	 */
	public function isHasAbility($ability) {
		foreach ($this->roles()->get('id') as $role) {
			if ($role->isHasAbility($ability)) {
				return true;
			}
		}

		return false;
	}


	/*
	 * Проверка статуса администратора
	 */
	public function isAdmin() {
		foreach ($this->roles()->get('id') as $role) {
			if ($role->isAdmin()) {
				return true;
			}
		}

		return false;
	}
}