<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model;

class Ability extends Model
{
	protected $table = 'base_abilities';

	protected $fillable = [
		'id',
		'name'
	];


	/*
	 * Роли
	 */
	public function roles() {
		return $this
			->belongsToMany(Role::class, 'base_ability_role')
			->withPivot('options');
	}
}