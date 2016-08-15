<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Comparable;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
	use BelongsToEditors, Comparable;

	protected $table = 'base_roles';

	protected $fillable = ['name'];


	/*
	 * Возможности
	 */
	public function abilities() {
		return $this->belongsToMany(Ability::class, 'base_ability_role');
	}


	/*
	 * Типы уведомлений
	 */
	public function noticesTypes() {
		return $this->belongsToMany(NoticesType::class, 'base_notices_type_role');
	}


	/*
	 * Пользователи
	 */
	public function users() {
		return $this->belongsToMany(User::class, 'base_role_user');
	}


	/*
	 * Проверка доступа
	 */
	public function hasAccess($abilityNamespace) {
		return (bool)$this
			->abilities()
			->where('id', 'LIKE', '%' . Ability::detectNamespace($abilityNamespace) . '.%')
			->count();
	}


	/*
	 * Проверка наличия возможности
	 */
	public function hasAbility($abilities) {
		if (!is_array($abilities)) {
			$abilities = [$abilities];
		}

		return (bool)$this
			->abilities()
			->whereIn('id', $abilities)
			->count();
	}


	/*
	 * Проверка статуса администратора
	 */
	public function isAdmin() {
		return (bool)$this
			->abilities()
			->counnt();
	}
}