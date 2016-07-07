<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
	protected $fillable = ['name'];


	/*
	 * Роли
	 */
	public function roles() {
		return $this->belongsToMany(Role::class);
	}
}