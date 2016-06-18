<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
	protected $fillable = [
		'content',
		'is_read'
	];
}