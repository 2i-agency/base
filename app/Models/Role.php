<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToDeleter;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Comparable;
use Chunker\Base\Models\Traits\IsRelatedWith;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Модель роли
 * @package Chunker\Base\Commands
 */
class Role extends Model
{
	use BelongsToEditors, Comparable, IsRelatedWith, SoftDeletes, BelongsToDeleter, LogsActivity;

	/** @var string имя таблицы */
	protected $table = 'base_roles';

	protected static $ignoreChangedAttributes = [
		'created_at',
		'updated_at',
		'deleted_at',
		'creator_id',
		'updater_id',
		'deleter_id'
	];

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [ 'name' ];

	/** @var array поля с датами */
	protected $dates = [ 'deleted_at' ];

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
	 * Агенты
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphMany
	 */
	public function agents() {
		return $this->morphMany(Agent::class, 'agent');
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

		/** Если есть связь хотя бы с одной возможностью из пространства имён */
		if (
		$this
			->abilities()
			->where('id', 'LIKE', '%' . Ability::detectNamespace($abilityNamespace) . '.%')
			->count()
		) {
			return true;
		}

		/** Если есть агент с возможностью из пространства имён */
		if (
		$this
			->agents()
			->where('ability_id', 'LIKE', '%' . Ability::detectNamespace($abilityNamespace) . '.%')
			->count()
		) {
			return true;
		}

		/** В ином случае у роли нет доступа */
		return false;
	}


	/**
	 * Проверка наличия возможности
	 *
	 * @param mixed $ability
	 * @param mixed $models
	 *
	 * @return bool
	 */
	public function hasAbility($ability, $models = NULL) {
		if (
		$this
			->abilities()
			->where('id', $ability)
			->count()
		) {
			return true;
		}

		/** Если есть связи с другими возможностями из этого пространства имён */
		if ($this->hasAccess($ability)) {

			/** Проверяем все связанные возможности */
			foreach ($this->abilities()->pluck('id') as $value) {

				/** Пространство имён проверяемой и переданной совпадают */
				if (Ability::detectNamespace($value) == Ability::detectNamespace($ability)) {

					/** Приоритет проверямеой выше чем переданной */
					if (Ability::getPriority($value, $ability)) {
						return true;
					}

				}
			}

		}

		/** Если передана модель или коллекциЯ моделей */
		if (!is_null($models)) {

			/** Если передана одна модель, оборачиаем её в коллекцию, для удобства */
			if ($models instanceof Model) {
				$models = ( new Collection() )->add($models);
			}

			/** Проходимся по всем переданным моделям */
			foreach ($models as $model) {
				/** TODO Нужно лучше продумать логику проверки по родителям, с учётом настроек самого ребёнка */
				if (method_exists($model, 'newNestedSetQuery')) {
					$result_ancestors = $this->hasAbility($ability, $model->getAncestors());
					if ($result_ancestors) {
						return true;
					}
				}

				/** Если у модели есть связь с агентами */
				if (method_exists($model, 'agents')) {

					$abilities = $model
						->agents()
						->whereIn('id', $this
							->agents()
							->pluck('id')
							->toArray()
						)
						->pluck('ability_id')
						->toArray();

					/** Проверяем все связанные возможности */
					foreach ($abilities as $value) {

						if (is_null($value)) {
							return false;
						}

						/** Пространство имён проверяемой и переданной совпадают */
						if (Ability::detectNamespace($value) == Ability::detectNamespace($ability)) {

							/** Приоритет проверямеой выше чем переданной */
							if (Ability::getPriority($value, $ability)) {
								return true;
							}

						}
					}
				}

			}
		}

		return false;
	}


	/**
	 * Проверяет существование возможности у самой роли
	 *
	 * @param $ability
	 *
	 * @return bool
	 */
	public function checkAbility($ability) {

		return (bool)$this
			->abilities()
			->where('id', $ability)
			->count();
	}


	/**
	 * Метод для замены стандартного описания действия
	 *
	 * @param string $eventName
	 *
	 * @return string
	 */
	public function getDescriptionForEvent(string $eventName):string {
		$actions = [
			'created'  => 'создал роль',
			'updated'  => 'отредактировал данные роли',
			'deleted'  => 'удалил роль',
			'restored' => 'восстановил роль'
		];

		if (!is_null(\Auth::user())) {
			return 'Пользователь <b>:causer.login</b> ' . $actions[ $eventName ] . ' <b>:subject.name</b>';
		} else {
			return '';
		}
	}


	/**
	 * Возвращает имя лога
	 *
	 * @param string $eventName
	 *
	 * @return string
	 */
	public function getLogNameToUse(string $eventName = ''):string {
		if ($eventName == '') {
			return config('laravel-activitylog.default_log_name');
		} else {
			return $eventName;
		}
	}
}