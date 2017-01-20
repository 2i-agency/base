<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\IsRelatedWith;
use Chunker\Base\Models\Traits\Nullable;
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
		'is_blocked'
	];

	/** @var array поля, которые должны быть скрыты при преобразовании модели в массив */
	protected $hidden = [
		'password',
		'remember_token',
	];

	/** @var array поля для мутаторов */
	protected $casts = [
		'is_subscribed' => 'boolean',
		'is_blocked'    => true
	];


	/**
	 * Возможности
	 */
	public function abilities() {
		return $this->morphToMany(Ability::class, 'base_abilities_roles_users');
	}


	/**
	 * Хеширование пароля
	 *
	 * @param string $password
	 */
	public function setPasswordAttribute($password){
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
	public function getName(){
		return is_null($this->name) ? $this->login : $this->name;
	}


	/**
	 * Можно ли заблокировать пользователя (пользователь не может заблокировать сам себя).
	 *
	 * @return bool
	 */
	public function isCanBeBlocked(){
		return !$this->is(Auth::user());
	}


	/**
	 * Аутентификации
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function authentications(){
		return $this->hasMany(Authentication::class);
	}


	/**
	 * Роли
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles(){
		return $this->belongsToMany(Role::class, 'base_roles_users');
	}


	/**
	 * Проверка доступа
	 *
	 * @param string $abilityNamespace пространство имён возможности
	 *
	 * @return bool
	 */
	public function hasAccess($abilityNamespace){
		foreach ($this->roles()->get([ 'id' ]) as $role) {
			if ($role->hasAccess($abilityNamespace)) {
				return true;
			}
		}

		return false;
	}


	/**
	 * Проверка наличия возможности
	 *
	 * @param string $ability возможности
	 *
	 * @return bool
	 */
	public function hasAbility($ability){
		foreach ($this->roles()->get([ 'id' ]) as $role) {
			if ($role->hasAbility($ability)) {
				return true;
			}
		}

		return false;
	}


	/**
	 * Проверка статуса администратора
	 *
	 * @todo переделать в соответствии с новой логикой работы
	 *
	 * @return bool
	 */
	public function isAdmin(){
		foreach ($this->roles()->get([ 'id' ]) as $role) {
			if ($role->isAdmin()) {
				return true;
			}
		}

		return false;
	}
}