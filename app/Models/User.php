<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Comparable;
use Auth;

class User extends Authenticatable
{
	use SoftDeletes, BelongsToEditors, Comparable, Nullable;

	protected $dates = ['deleted_at'];
	protected $nullable = ['name'];

	protected $fillable = [
		'login',
		'password',
		'email',
		'name',
		'is_subscribed'
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'is_subscribed' => 'boolean'
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