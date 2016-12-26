<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель возможности
 *
 * @package Chunker\Base\Commands
 */
class Ability extends Model
{
	/** @var string имя таблицы */
	protected $table = 'base_abilities';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'id',
		'name'
	];


	/**
	 * Определение пространства имен
	 *
	 * @param string $ability роль
	 *
	 * @return string название роли
	 */
	public static function detectNamespace($ability){
		return explode('.', $ability)[ 0 ];
	}


	/**
	 * Получение пространства имен
	 *
	 * @return string
	 */
	public function getNamespace(){
		return static::detectNamespace($this->id);
	}


	/**
	 * Отношение с моделью Role
	 *
	 * @return mixed связь с моделью User
	 */
	public function roles(){
		return $this
			->belongsToMany(Role::class, 'base_ability_role')
			->withPivot('options');
	}
}