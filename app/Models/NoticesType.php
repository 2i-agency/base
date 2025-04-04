<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToDeleter;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Модель типов уведомлений
 *
 * @package Chunker\Base\Commands
 */
class NoticesType extends Model
{
	use Nullable, BelongsToEditors, SoftDeletes, BelongsToDeleter, LogsActivity;

	/** @var string имя таблицы */
	protected $table = 'base_notices_types';

	protected static $ignoreChangedAttributes = [
		'created_at',
		'updated_at',
		'deleted_at',
		'creator_id',
		'updater_id',
		'deleter_id'
	];

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'tag',
		'name'
	];

	/** @var array поля с датами */
	protected $dates = [ 'deleted_at' ];

	/** @var array поля принимающие null */
	protected $nullable = [ 'tag' ];

	protected $ability = 'notices-types';


	/**
	 * Уведомления
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function notices() {
		return $this->hasMany(Notice::class, 'type_id');
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function roles() {
		return $this->morphedByMany(Role::class, 'model', 'base_notices_type_role_user');
	}


	/**
	 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
	 */
	public function users() {
		return $this->morphedByMany(User::class, 'model', 'base_notices_type_role_user');
	}


	public static function boot() {

		/**
		 * Очистка ключа типа у уведомлений
		 */
		static::deleting(function($instance) {
			$instance
				->notices()
				->update([ 'type_id' => NULL ]);
		});

		parent::boot();
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
			'created'  => 'создал тип уведомлений',
			'updated'  => 'отредактировал данные типа уведомления',
			'deleted'  => 'удалил тип уведомлений',
			'restored' => 'восстановил тип уведомлений'
		];

		if (!is_null(\Auth::user())){
			return 'Пользователь <b>:causer.login</b> ' . $actions[ $eventName ] . ': <b>:subject.name</b>';
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