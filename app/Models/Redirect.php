<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;
use League\Uri\Schemes\Http;

class Redirect extends Model
{
	use Nullable, BelongsToEditors;

	protected $table = 'base_redirects';

	protected $fillable = [
		'from',
		'to',
		'comment',
		'is_active'
	];

	protected $nullable = [
		'comment'
	];


	/*
	 * Преобразование строки в путь с запросом
	 */
	public static function prepareFrom($from) {
		$uri = Http::createFromString($from);

		$from = '/' . $uri
				->path
				->withoutEmptySegments()
				->withoutDotSegments()
				->withoutLeadingSlash();
		$from .= $uri->getQuery() ? '?' . $uri->getQuery() : NULL;

		return $from;
	}


	/*
	 * В поле `Откуда` хранится адрес без хоста и протокола
	 */
	public function setFromAttribute($from) {
		$this->attributes['from'] = static::prepareFrom($from);
	}
}