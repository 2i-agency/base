<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\User;

trait HasCreator
{
	/*
	 * Пользователь-создатель
	 */
	public function creator()
	{
		return $this->belongsTo(User::class, 'creator_id');
	}
}