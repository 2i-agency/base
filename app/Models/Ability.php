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
	 * Определение пространства имен
	 */
	public static function detectNamespace($ability) {
		return explode('.', $ability)[0];
	}


	/*
	 * Получение пространства имен
	 */
	public function getNamespace() {
		return static::detectNamespace($this->id);
	}


	/*
	 * Роли
	 */
	public function roles() {
		return $this
			->belongsToMany(Role::class, 'base_ability_role')
			->withPivot('options');
	}
}