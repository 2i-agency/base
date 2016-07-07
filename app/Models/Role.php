<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	use BelongsToEditors;

	protected $fillable = ['name'];


	/*
	 * Возможности
	 */
	public function abilities() {
		return $this->belongsToMany(Ability::class);
	}


	/*
	 * Пользователи
	 */
	public function users() {
		return $this->belongsToMany(User::class);
	}
}