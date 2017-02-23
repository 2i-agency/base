<?php
namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\Agent;

/**
 * Трейт для связи моделей с представителями
 *
 * @package Chunker\Base\Models\Traits
 */
trait ModelsRelations
{
	/**
	 * Связь представителями (ролями или пользователями)
	 *
	 * @return mixed
	 */
	public function agents() {
		return $this->morphToMany(Agent::class, 'base_agents_models');
	}


	/**
	 * Метод выполняющийся при загрузке трейта
	 */
	protected static function bootSlugs(){
		self::created(function ($instance) {
			$request = \Request::all();

			if (isset($request['agents'])) {
				$instance->agents()->attach($request['agents']);
			}

			if (isset($request['abilities'])) {
				$instance->agents()->abilities()->attach($request['abilities']);
			}

		});


		self::saving(function($instance){
			$request = \Request::all();

			if (isset($request['agents'])) {
				$instance->agents()->sync($request['agents']);
			}

			if (isset($request['abilities'])) {
				$instance->agents()->abilities()->sync($request['abilities']);
			}

		});

		self::deleted(function ($instance) {

			$instance->agents()->detach();
			$instance->agents()->abilities()->detach();

		});
	}

}