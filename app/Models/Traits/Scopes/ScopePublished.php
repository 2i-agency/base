<?php

namespace Chunker\Base\Models\Traits\Scopes;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Добавляет фильтрацию по опубликованным записям
 *
 * @package Chunker\Base\Models\Traits\Scopes
 */
trait ScopePublished
{
	/**
	 * Фильтрация записей у которых время публикации раньше чем текущее время
	 *
	 * @param Builder $query
	 *
	 * @return Builder $query
	 */
	public function scopePublished(Builder $query){
		return $query->where('published_at', '<=', Carbon::now());
	}
}