<?php

namespace Chunker\Admin\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
	protected $fillable = [
		'user_id',
		'user_agent',
		'ip_address',
		'failed'
	];


	/*
	 * Owner of authorization
	 */
	public function user()
	{
		return $this->belongsTo(Chunker\Admin\Models\User::class);
	}
}
