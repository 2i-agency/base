<?php

namespace Chunker\Base\Models\Observers;

use Illuminate\Database\Eloquent\Model;
use App;
use Storage;

class LanguageObserver
{
	public function creating(Model $model) {
		$this->makeRouteKey($model);
	}


	public function updating(Model $model) {
		$this->makeRouteKey($model);
	}


	/*
	 * Формирование ключа маршрута на основе названия
	 */
	public function makeRouteKey(Model $model) {
		$route_key = trim($model->route_key);
		$model->route_key = mb_strlen($route_key) ? $route_key : $model->name;
	}
}