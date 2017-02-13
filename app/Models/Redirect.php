<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToDeleter;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;
use League\Uri\Schemes\Http;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * Модель перенаправлений
 *
 * @package Chunker\Base\Commands
 */
class Redirect extends Model
{
	use Nullable, BelongsToEditors, BelongsToDeleter, LogsActivity;

	/** @var string имя таблицы */
	protected $table = 'base_redirects';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'from',
		'to',
		'comment',
		'is_active'
	];

	/** @var array поля принимающие null */
	protected $nullable = [
		'comment'
	];

	/** @var array поля с датами */
	protected $dates = ['deleted_at'];

	protected $ability = 'redirects';


	/**
	 * Преобразование строки в путь с запросом
	 *
	 * @param string $from
	 *
	 * @return string
	 */
	public static function prepareFrom($from){
		$uri = Http::createFromString($from);

		$from = '/' . $uri
				->path
				->withoutEmptySegments()
				->withoutDotSegments()
				->withoutLeadingSlash();
		$from .= $uri->getQuery() ? '?' . $uri->getQuery() : NULL;

		return $from;
	}


	/**
	 * Преобразование значения поля "Откуда".
	 * В поле `Откуда` хранится адрес без хоста и протокола
	 *
	 * @param string $from
	 */
	public function setFromAttribute($from){
		$this->attributes[ 'from' ] = static::prepareFrom($from);
	}


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
			'created' => 'создал перенаправление',
			'updated' => 'отредактировал данные перенаправления',
			'deleted' => 'удалил перенаправление'
		];

		return 'Пользователь <b>:causer.login</b> ' . $actions[$eventName] . ': <b>:subject.from -> :subject.to</b>';
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