<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\Traits\Scopes\ScopeByPublicationTime;
use Chunker\Base\Models\Traits\Scopes\ScopeNotPublished;
use Chunker\Base\Models\Traits\Scopes\ScopePublished;

trait Publicable
{
	use ScopeByPublicationTime, ScopePublished, ScopeNotPublished, HasDates;


	/*
	 * Форматирование времени публикации
	 */
	public function setPublishedAtAttribute($time) {
		$this->prepareTime('published_at', $time);
	}


	/*
	 * Проверка на неопубликованность
	 */
	public function isNotPublished() {
		return is_null($this->published_at);
	}


	/*
	 * Проверка на опубликованность
	 */
	public function isPublished() {
		return $this->isNotPublished();
	}
}