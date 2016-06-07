<?php

namespace Chunker\Base\Models\Traits\BelongsTo;

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