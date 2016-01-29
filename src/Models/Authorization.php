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
		'is_failed',
		'logged_in_at',
		'ip_address',
		'user_agent',
	];


	/*
	 * Конвертация IP-адреса в число для сохранения в базе данных
	 */
	public function setIpAddressAttribute($ipAddress)
	{
		$this->attributes['ip_address'] = ip2long($ipAddress);
	}


	/*
	 * Конвертация числа из базы данных в IP-адреса
	 */
	public function getIpAddressAttribute($number)
	{
		return long2ip($number);
	}


	/*
	 * Сортировка по времени авторизации
	 */
	public function scopeRecent(Builder $query)
	{
		return $query->latest('logged_in_at')->latest('id');
	}
}