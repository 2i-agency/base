<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Comparable;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель роли
 * @package Chunker\Base\Commands
 */
class Role extends Model
{
	use BelongsToEditors, Comparable;

	/** @var string имя таблицы */
	protected $table = 'base_roles';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [ 'name' ];


	/**
	 * Возможности
	 */
	public function abilities() {
		return $this->morphToMany(Ability::class, 'base_abilities_agents');
	}


	/**
	 * Типы уведомлений
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function noticesTypes() {
		return $this->belongsToMany(NoticesType::class, 'base_notices_type_role');
	}


	/**
	 * Пользователи
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users() {
		return $this->belongsToMany(User::class, 'base_role_user');
	}


	/**
	 * Проверка доступа
	 *
	 * @param string $abilityNamespace пространство имён возможности
	 *
	 * @return bool
	 */
	public function hasAccess($abilityNamespace) {
		return (bool)$this
			->abilities()
			->where('id', 'LIKE', '%' . Ability::detectNamespace($abilityNamespace) . '.%')
			->count();
	}


	/**
	 * Проверка наличия возможности
	 *
	 * @param string $abilities возможности
	 *
	 * @return bool
	 */
	public function hasAbility($abilities) {
		if (!is_array($abilities)) {
			$abilities = [ $abilities ];
		}

		return (bool)$this
			->abilities()
			->whereIn('id', $abilities)
			->count();
	}


	/**
	 * Проверка статуса администратора
	 *
	 * @todo переделать в соответствии с новой логикой работы
	 *
	 * @return bool
	 */
	public function isAdmin() {
		return (bool)$this
			->abilities()
			->count();
	}


	public static function boot() {

		/**
		 * Удаление связей роли с возможностями, типами уведомлений, пользователями
		 */
		static::deleting(function($instance) {
			// Удаление связей с возможностями
			$instance->abilities()->detach();

			// Удаление связей с типами уведомлений
			$instance->noticesTypes()->detach();

			// Удаление связей с пользователями
			$instance->users()->detach();
		});

		parent::boot();
	}
}