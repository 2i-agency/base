<?php

namespace Chunker\Base\Models\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScopeByPublicationTime
{
	/*
	 * Сортировка в обратном порядке публикации
	 */
	public function scopeByPublicationTime(Builder $query) {
		return $query->latest('published_at');
	}
}