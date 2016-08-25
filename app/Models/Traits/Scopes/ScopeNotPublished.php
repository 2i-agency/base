<?php

namespace Chunker\Base\Models\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait ScopeNotPublished
{
	/*
	 * Фильтрация неопубликованных записей
	 */
	public function scopeNotPublished(Builder $query) {
		return $query->whereNull('published_at');
	}
}