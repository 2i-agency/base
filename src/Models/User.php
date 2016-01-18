<?php

namespace Chunker\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Chunker\Admin\Models\Traits\LinkedWithEditors;

class User extends Model
{
	use LinkedWithEditors;

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
		return $this->hasMany(Chunker\Admin\Models\Authorization::class);
	}
}
