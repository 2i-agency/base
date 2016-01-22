<?php

namespace Chunker\Base\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Chunker\Base\Models\Traits\HasEditors;
use Chunker\Base\Models\Traits\Comparison;
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
	 * Hashing password
	 */
	public function setPasswordAttribute($password)
	{
		if (strlen($password))
		{
			$this->attributes['password'] = bcrypt($password);
		}
	}


	/*
	 * Preparing login
	 */
	public function setLoginAttribute($login)
	{
		$this->attributes['login'] = str_slug($login);
	}


	/*
	 * Triming name
	 */
	public function setNameAttribute($name)
	{
		$name = trim($name);
		$this->attributes['name'] = strlen($name) ? $name : NULL;
	}


	/*
	 * Getting name, which may be empty
	 */
	public function getName()
	{
		return is_null($this->name) ? $this->login : $this->name;
	}


	/*
	 * Checking deleting opportunity
	 */
	public function isCanBeDeleted()
	{
		$is_can = !$this->is(Auth::user());
		$is_can = $is_can && static::count() > 1;

		return $is_can;
	}


	/*
	 * User's authorizations
	 */
	public function authorizations()
	{
		return $this->hasMany(\Chunker\Base\Models\Authorization::class);
	}
}
