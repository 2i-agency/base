<?php

namespace Chunker\Base\Models\Traits\Scopes;

use Illuminate\Database\Eloquent\Builder;

/**
 * Добавляет фильтрацию по неопубликованным записям
 *
 * @package Chunker\Base\Models\Traits\Scopes
 */
trait ScopeNotPublished
{
	/**
	 * Фильтрация записей у которых время публикации позже чем текущее время
	 *
	 * @param Builder $query
	 *
	 * @return Builder $query
	 */
	public function scopeNotPublished(Builder $query){
		return $query->where(function($query){
			$query
				->where('published_at', '>', Carbon::now())
				->orWhere('published_at', 'Null');
		});
	}
}