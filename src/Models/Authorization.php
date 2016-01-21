<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Authorization extends Model
{
	public $timestamps = false;
	protected $timeFormat = 'd.m.Y H:i:s';

	protected $dates = [
		'logged_in_at',
		'last_request_at'
	];

	protected $fillable = [
		'failed',
		'logged_in_at',
		'ip_address',
		'user_agent',
	];


	/*
	 * Converting ip_address to number for storing in database
	 */
	public function setIpAddressAttribute($ipAddress)
	{
		$this->attributes['ip_address'] = ip2long($ipAddress);
	}


	/*
	 * Converting number from database to ip_address
	 */
	public function getIpAddressAttribute($number)
	{
		return long2ip($number);
	}


	/*
	 * Ordering by time
	 */
	public function scopeRecent(Builder $query)
	{
		return $query->latest('logged_in_at');
	}


	/*
	 * Last
	 */
	public function last()
	{
		return $this->recent()->first();
	}


	/*
	 * Owner of authorization
	 */
	public function user()
	{
		return $this->belongsTo(\Chunker\Base\Models\User::class);
	}
}