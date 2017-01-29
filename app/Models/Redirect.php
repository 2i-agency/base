<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use League\Uri\Schemes\Http;

/**
 * Модель перенаправлений
 *
 * @package Chunker\Base\Commands
 */
class Redirect extends Model
{
	use Nullable, BelongsToEditors, SoftDeletes;

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
}