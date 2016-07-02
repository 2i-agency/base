<?php

namespace Chunker\Base\Models\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScopeIsNotPublished
{
	/*
	 * Фильтрация неопубликованных записей
	 */
	public function scopeIsNotPublished(Builder $query) {
		return $query->whereNull('published_at');
	}
}