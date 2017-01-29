<?php

namespace Chunker\Base\Models\Traits\BelongsTo;

use Chunker\Base\Models\User;
use Auth;

/**
 * Трейт для подключения связи с пользователем, создавшем модель
 *
 * @package Chunker\Base\Models\Traits\BelongsTo
 */
trait BelongsToDeleter
{

	/**
	 * Пользователь-создатель
	 *
	 * @return Eloquement - связь с моделью User
	 */
	public function deleter(){
		return $this->belongsTo(User::class, 'deleter_id');
	}


	public function scopeWithDelete($query, $ability)
	{
		if (\Auth::user()->hasAdminAccess($ability, $this)) {
			return $query->withTrashed();
		}

		return $query;
	}


	public static function bootBelongsToDeletor(){
		static::deleting(function($model){
			$model
				->deletor()
				->associate(Auth::user());
		});
	}
}