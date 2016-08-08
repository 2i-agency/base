<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
	protected $table = 'base_notices';

	protected $fillable = [
		'content',
		'is_read',
		'type_id'
	];


	/*
	 * Тип
	 */
	public function type() {
		return $this->belongsTo(NoticesType::class, 'type_id');
	}
}