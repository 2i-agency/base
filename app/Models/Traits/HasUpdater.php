<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\User;

trait HasUpdater
{
	/*
	 * Пользователь-редактор
	 */
	public function updater()
	{
		return $this->belongsTo(User::class, 'updater_id');
	}
}