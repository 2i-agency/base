<?php

namespace Chunker\Base\Models\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScopeIsPublished
{
	/*
	 * Фильтрация опубликованных записей
	 */
	public function scopeIsPublished(Builder $query) {
		return $query->whereNotNull('published_at');
	}
}