<?php

namespace Chunker\Base\Models\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScopePublished
{
	/*
	 * Фильтрация опубликованных записей
	 */
	public function scopePublished(Builder $query) {
		return $query->whereNotNull('published_at');
	}
}