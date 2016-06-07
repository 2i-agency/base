<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\User;

trait BelongsToUpdater
{
	/*
	 * Пользователь-обновитель
	 */
	public function updater() {
		return $this->belongsTo(User::class, 'updater_id');
	}
}