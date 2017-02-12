<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToUpdater;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Модель настроек
 *
 * @package Chunker\Base\Commands
 */
class Setting extends Model
{
	use BelongsToUpdater, Nullable, LogsActivity;

	/** @var string имя таблицы */
	protected $table = 'base_settings';

	/** @var array поля для мутаторов */
	protected $casts = [ 'id' => 'string' ];
	/** @var array поля принимающие null */
	protected $nullable = [ 'value', 'hint' ];
	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'id',
		'title',
		'value',
		'control_type',
		'hint'
	];


	/**
	 * Метод для замены стандартного описания действия
	 *
	 * @param string $eventName
	 *
	 * @return string
	 */
	public function getDescriptionForEvent(string $eventName): string
	{
		$actions = [
			'updated' => 'отредактировал настройки'
		];

		return 'Пользователь ":causer.login" ' . $actions[$eventName] . ': ":subject.title"';
	}


	/**
	 * Возвращает имя лога
	 *
	 * @param string $eventName
	 *
	 * @return string
	 */
	public function getLogNameToUse(string $eventName = ''): string
	{
		if ($eventName == '') {
			return config('laravel-activitylog.default_log_name');
		} else {
			return $eventName;
		}
	}
}