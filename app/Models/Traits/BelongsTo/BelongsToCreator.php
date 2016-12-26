<?php

namespace Chunker\Base\Models\Traits\BelongsTo;

use Chunker\Base\Models\User;
use Auth;

/**
 * Трейт для подключения связи с пользователем, создавшем модель
 *
 * @package Chunker\Base\Models\Traits\BelongsTo
 */
trait BelongsToCreator
{
	/**
	 * Пользователь-создатель
	 *
	 * @return Eloquement - связь с моделью User
	 */
	public function creator() {
		return $this->belongsTo(User::class, 'creator_id');
	}


	public static function bootBelongsToCreator() {
		static::creating(function($model){
			$model
				->creator()
				->associate(Auth::user());
		});
	}
}