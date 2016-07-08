<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Comparable;
use Auth;

class User extends Authenticatable
{
	use BelongsToEditors, Comparable, Nullable;

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
		return $this->belongsToMany(Role::class);
	}
}