<?php

namespace Chunker\Base\Models\Traits\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

trait ScopePublished
{
	/*
	 * Фильтрация опубликованных записей
	 */
	public function scopePublished(Builder $query) {
		return $query->where('published_at', '<=', Carbon::now());
	}
}