<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\User;

trait HasCreator
{
	/*
	 * User which created
	 */
	public function creator()
	{
		return $this->belongsTo(User::class, 'creator_id');
	}
}