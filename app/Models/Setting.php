<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToUpdater;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
	use BelongsToUpdater, Nullable;

	protected $casts = ['id' => 'string'];
	protected $nullable = ['value', 'hint'];

	protected $fillable = [
		'id',
		'title',
		'value',
		'control_type',
		'hint'
	];
}