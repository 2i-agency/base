<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Comparable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	use BelongsToEditors, Comparable;

	protected $fillable = ['name'];


	/*
	 * Возможности
	 */
	public function abilities() {
		return $this
			->belongsToMany(Ability::class)
			->withPivot('options');
	}


	/*
	 * Проверка наличия возможности
	 */
	public function hasAbility($abilityId) {
		return (bool)$this
			->abilities()
			->where('id', $abilityId)
			->count();
	}


	/*
	 * Пользователи
	 */
	public function users() {
		return $this->belongsToMany(User::class);
	}
}