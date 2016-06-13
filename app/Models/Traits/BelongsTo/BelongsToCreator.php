<?php

namespace Chunker\Base\Models\Traits\BelongsTo;

use Chunker\Base\Models\User;
use Auth;

trait BelongsToCreator
{
	/*
	 * Пользователь-создатель
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