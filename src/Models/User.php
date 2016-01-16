<?php

namespace Chunker\Admin\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Chunker\Admin\Models\Traits\LinkedWithEditors;

class User extends Authenticatable
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
	 * User's authorizations
	 */
	public function authorizations()
	{
		return $this->hasMany(Chunker\Admin\Models\Authorization::class);
	}
}
