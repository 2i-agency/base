<?php

namespace Chunker\Base\Models\Traits;

use Carbon\Carbon;
use Chunker\Base\Models\Traits\Scopes\ScopeByPublicationTime;
use Chunker\Base\Models\Traits\Scopes\ScopeNotPublished;
use Chunker\Base\Models\Traits\Scopes\ScopePublished;

/**
 * Трейт, для работы с полем публикации
 *
 * @package Chunker\Base\Models\Traits
 */
trait Publicable
{
	use ScopeByPublicationTime, ScopePublished, ScopeNotPublished, HasDates;

	/**
	 * Форматирование времени публикации
	 *
	 * @param string $time
	 */
	public function setPublishedAtAttribute($time){
		$this->prepareTime('published_at', $time);
	}


	/**
	 * Проверка на неопубликованность
	 *
	 * @return bool
	 */
	public function isNotPublished(){
		return Carbon::now()->lte(Carbon::parse($this->published_at));
	}


	/**
	 * Проверка на опубликованность
	 *
	 * @return bool
	 */
	public function isPublished(){
		return !$this->isNotPublished();
	}
}