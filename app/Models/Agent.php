<?php
namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\Nullable;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
	use Nullable;

	/** @var string имя таблицы */
	protected $table = 'base_agents';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'agent_id',
		'agent_type',
		'model_id',
		'model_type',
		'ability_id'
	];

	protected $nullable = [ 'ability_id' ];

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
		return $this->morphTo('agent');
	}


	public function models()
	{
		return $this->morphTo('model');
	}
}