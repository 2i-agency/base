<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\User;

trait BelongsToCreator
{
	/*
	 * Пользователь-создатель
	 */
	public function creator() {
		return $this->belongsTo(User::class, 'creator_id');
	}
}