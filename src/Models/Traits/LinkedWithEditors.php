<?php

namespace Chunker\Admin\Models\Traits;

trait LinkedWithEditors
{
	/*
	 * User which created
	 */
	public function creator()
	{
		return $this->belongsTo(Chunker\Admin\Models\User::class, 'creator_id');
	}


	/*
	 * User which updated last
	 */
	public function updater()
	{
		return $this->belongsTo(Chunker\Admin\Models\User::class, 'updater_id');
	}
}