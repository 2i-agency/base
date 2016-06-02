<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\Bounded;
use Chunker\Base\Models\Traits\HasEditors;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
	use HasEditors, Bounded;

	protected $fillable = [
		'name',
		'route_key',
		'is_published'
	];


	/*
	 * Настройка ключа для привязки к маршруту
	 */
	public function getRouteKeyName()
	{
		return 'route_key';
	}


	/*
	 * Подготовка ключ маршрута
	 */
	public function setRouteKeyAttribute($routeKey)
	{
		$this->attributes['route_key'] = str_slug(trim($routeKey));
	}
}