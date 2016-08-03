<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;

class Authentication extends Model
{
	protected $table = 'base_authentications';

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
		'last_request_at'
	];

	protected $casts = [
		'is_failed' => 'boolean'
	];


	/*
	 * Конвертация IP-адреса в число для сохранения в базе данных
	 */
	public function setIpAddressAttribute($ipAddress) {
		$this->attributes['ip_address'] = ip2long($ipAddress);
	}


	/*
	 * Конвертация числа из базы данных в IP-адреса
	 */
	public function getIpAddressAttribute($number) {
		return long2ip($number);
	}


	/*
	 * Сортировка по времени авторизации
	 */
	public function scopeRecent(Builder $query) {
		return $query
			->latest('logged_in_at')
			->latest('id');
	}
	
	
	/*
	 * Информация о браузере
	 */
	public function getBrowser()
	{
		return new Browser($this->user_agent);
	}
	
	
	/*
	 * Информация об ОС
	 */
	public function getOs()
	{
		return new Os($this->user_agent);
	}
}