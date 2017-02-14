<?php

namespace Chunker\Base\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Sinergi\BrowserDetector\Browser;
use Sinergi\BrowserDetector\Os;

/**
 * Модель аутентификации
 *
 * @package Chunker\Base\Commands
 */
class Authentication extends Model
{
	/** @var string название таблицы */
	protected $table = 'base_authentications';
	/** @var bool отключение timestamp полей */
	public $timestamps = false;
	/** @var string формат времени */
	protected $timeFormat = 'd.m.Y H:i:s';

	/** @var array поля с датами */
	protected $dates = [
		'logged_in_at',
		'last_request_at'
	];

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'is_failed',
		'logged_in_at',
		'ip_address',
		'user_agent',
		'last_request_at'
	];

	/** @var array поля для мутаторов */
	protected $casts = [
		'is_failed' => 'boolean'
	];


	/**
	 * Конвертация IP-адреса в число для сохранения в базе данных
	 *
	 * @param string $ipAddress
	 */
	public function setIpAddressAttribute($ipAddress){
		$this->attributes[ 'ip_address' ] = ip2long($ipAddress);
	}


	/**
	 * Конвертация числа из базы данных в IP-адреса
	 *
	 * @param string|int $number
	 *
	 * @return string
	 */
	public function getIpAddressAttribute($number){
		return long2ip($number);
	}


	/**
	 * Сортировка по времени авторизации
	 *
	 * @param Builder $query
	 *
	 * @return mixed
	 */
	public function scopeRecent(Builder $query){
		return $query
			->latest('logged_in_at')
			->latest('id');
	}


	/**
	 * Информация о браузере
	 *
	 * @return Browser
	 */
	public function getBrowser(){
		return new Browser($this->user_agent);
	}


	/**
	 * Информация об ОС
	 *
	 * @return Os
	 */
	public function getOs(){
		return new Os($this->user_agent);
	}


	public static function boot(){

		/**
		 * Заполнение атрибутов данными о компьютере пользователя
		 */
		static::creating(function($instance){
			$request = request();

			$instance->fill([
				'logged_in_at' => Carbon::now(),
				'ip_address'   => $request->ip(),
				'user_agent'   => $request->server('HTTP_USER_AGENT')
			]);
		});

		parent::boot();
	}
}