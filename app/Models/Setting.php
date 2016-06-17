<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToUpdater;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	use BelongsToUpdater;

	protected $casts = ['id' => 'string'];

	protected $fillable = [
		'id',
		'title',
		'value',
		'control_type',
		'hint'
	];
}