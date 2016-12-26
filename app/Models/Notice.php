<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель уведомлений
 *
 * @package Chunker\Base\Commands
 */
class Notice extends Model
{
	/** @var string название таблицы */
	protected $table = 'base_notices';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'content',
		'is_read',
		'type_id'
	];


	/**
	 * Тип уведомлений
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function type(){
		return $this->belongsTo(NoticesType::class, 'type_id');
	}
}