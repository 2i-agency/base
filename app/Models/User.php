<?php

namespace Chunker\Base\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Chunker\Base\Models\Traits\HasEditors;
use Chunker\Base\Models\Traits\Comparison;
use Chunker\Base\Models\Authentication;
use Auth;

class User extends Authenticatable
{
	use SoftDeletes, HasEditors, Comparison;

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'login',
		'password',
		'email',
		'name'
	];

	protected $hidden = [
		'password',
		'remember_token',
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
	 * Подготовка логина
	 */
	public function setLoginAttribute($login) {
		$this->attributes['login'] = str_slug($login);
	}


	/*
	 * Подготовка имени
	 */
	public function setNameAttribute($name) {
		$name = trim($name);
		$this->attributes['name'] = strlen($name) ? $name : NULL;
	}


	/*
	 * Если для пользователя не задано имя, то возвращается логин
	 */
	public function getName() {
		return is_null($this->name) ? $this->login : $this->name;
	}


	/*
	 * Пользователь не может удалить сам себя
	 */
	public function isCanBeDeleted() {
		return !$this->is(Auth::user());
	}


	/*
	 * Аутентификайии
	 */
	public function authentications() {
		return $this->hasMany(Authentication::class);
	}
}