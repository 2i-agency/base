<?php
/**
 * Created by PhpStorm.
 * User: boldyreva
 * Date: 20.01.17
 * Time: 12:20
 */

namespace chunker\base\app\Models;


use Chunker\Base\Models\Ability;
use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
	/** @var string имя таблицы */
	protected $table = 'base_agents';

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
		return $this->morphTo();
	}
}