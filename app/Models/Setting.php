<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\BelongsTo\BelongsToUpdater;
use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель настроек
 *
 * @package Chunker\Base\Commands
 */
class Setting extends Model
{
	use BelongsToUpdater, Nullable;

	/** @var string имя таблицы */
	protected $table = 'base_settings';

	/** @var array поля для мутаторов */
	protected $casts = [ 'id' => 'string' ];
	/** @var array поля принимающие null */
	protected $nullable = [ 'value', 'hint' ];
	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'id',
		'title',
		'value',
		'control_type',
		'hint'
	];
}