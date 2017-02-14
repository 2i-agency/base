<?php

namespace Chunker\Base\Models\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Добавляет в запрос сортировку по дате публикации
 * (сначало новые)
 *
 * @package Chunker\Base\Models\Traits\Scopes
 */
trait ScopeByPublicationTime
{
	/**
	 * Сортировка в обратном порядке публикации
	 *
	 * @param Builder $query
	 *
	 * @return Builder $query
	 */
	public function scopeByPublicationTime(Builder $query){
		return $query->latest('published_at');
	}
}