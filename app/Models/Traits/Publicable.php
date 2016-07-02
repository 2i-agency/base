<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\Traits\Scopes\ScopeByPublicationTime;
use Chunker\Base\Models\Traits\Scopes\ScopeIsNotPublished;
use Chunker\Base\Models\Traits\Scopes\ScopeIsPublished;

trait Publicable
{
	use ScopeByPublicationTime, ScopeIsPublished, ScopeIsNotPublished, HasDates;


	/*
	 * Форматирование времени публикации
	 */
	public function setPublishedAtAttribute($time) {
		$this->prepareTime('published_at', $time);
	}
}