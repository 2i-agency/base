<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToDeleter;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Comparable;
use Chunker\Base\Models\Traits\IsRelatedWith;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Модель роли
 * @package Chunker\Base\Commands
 */
class Role extends Model
{
	use BelongsToEditors, Comparable, IsRelatedWith, SoftDeletes, BelongsToDeleter;

	/** @var string имя таблицы */
	protected $table = 'base_roles';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [ 'name' ];

	/** @var array поля с датами */
	protected $dates = ['deleted_at'];

	protected $ability = 'roles';


	/**
	 * Возможности
	 */
	public function abilities() {
		return $this->morphToMany(Ability::class, 'model', 'base_abilities_roles_users');
	}


	/**
	 * Типы уведомлений
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function noticesTypes() {
		return $this->morphToMany(NoticesType::class, 'model', 'base_notices_type_role_user');
	}


	/**
	 * Пользователи
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function users() {
		return $this->belongsToMany(User::class, 'base_roles_users');
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