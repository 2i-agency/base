<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель типов уведомлений
 *
 * @package Chunker\Base\Commands
 */
class NoticesType extends Model
{
	use Nullable, BelongsToEditors;

	/** @var string имя таблицы */
	protected $table = 'base_notices_types';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'tag',
		'name'
	];

	/** @var array поля принимающие null */
	protected $nullable = [ 'tag' ];


	/**
	 * Уведомления
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function notices(){
		return $this->hasMany(Notice::class, 'type_id');
	}


	/**
	 * Роли
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function roles(){
		return $this->belongsToMany(Role::class, 'base_notices_type_role');
	}
}