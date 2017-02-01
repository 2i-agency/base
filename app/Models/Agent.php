<?php
namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
	/** @var string имя таблицы */
	protected $table = 'base_agents';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'model_id',
		'model_type',
		'ability_id'
	];

	public $timestamps = false;

	/**
	 * Связь агента с возможностью
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function ability()
	{
		return $this->belongsTo(Ability::class);
	}

	/**
	 * Связь агента с пользователем или ролью
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\MorphTo
	 */
	public function agentable()
	{
		return $this->morphTo('model');
	}
}