<?php

namespace Chunker\Base\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Chunker\Base\Models\Traits\LinkedWithEditors;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
	use LinkedWithEditors, SoftDeletes;

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
		$this->attributes['password'] = bcrypt($password);
	}


	/*
	 * User's authorizations
	 */
	public function authorizations()
	{
		return $this->hasMany(\Chunker\Base\Models\Authorization::class);
	}
}
