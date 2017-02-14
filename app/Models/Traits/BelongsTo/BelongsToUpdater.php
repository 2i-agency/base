<?php

namespace Chunker\Base\Models\Traits\BelongsTo;

use Chunker\Base\Models\User;
use Auth;

/**
 * Трейт для подключения связи с пользователем, обновившим модель
 *
 * @package Chunker\Base\Models\Traits\BelongsTo
 */
trait BelongsToUpdater
{
	/**
	 * Пользователь-обновитель
	 *
	 * @return mixed - связь с моделью User
	 */
	public function updater(){
		return $this->belongsTo(User::class, 'updater_id');
	}


	public static function bootBelongsToUpdater(){
		static::creating(function($model){
			$model
				->updater()
				->associate(Auth::user());
		});

		static::updating(function($model){
			$model
				->updater()
				->associate(Auth::user());
		});
	}
}