<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;

class Language extends Model
{
	use BelongsToEditors, NodeTrait;

	protected $fillable = [
		'name',
		'route_key',
		'is_published'
	];

	protected $casts = [
		'is_published' => 'boolean'
	];


	/*
	 * Настройка ключа для привязки к маршруту
	 */
	public function getRouteKeyName() {
		return 'route_key';
	}


	/*
	 * Подготовка ключа маршрута
	 */
	public function setRouteKeyAttribute($routeKey) {
		$this->attributes['route_key'] = str_slug(trim($routeKey));
	}
}