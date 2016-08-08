<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;

class NoticesType extends Model
{
	use Nullable, BelongsToEditors;

	protected $table = 'base_notices_types';

	protected $fillable = [
		'tag',
		'name'
	];

	protected $nullable = [ 'tag' ];


	/*
	 * Уведомления
	 */
	public function notices() {
		return $this->hasMany(Notice::class, 'type_id');
	}
}