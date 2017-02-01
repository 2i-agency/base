<?php
namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\Agent;

trait RelationAgents
{
	public function agents() {
		return $this->morphMany(Agent::class, 'model');
	}

	public function ScopeOnlyAccess($query, $ability) {

		if (\Auth::user()->id == 1) {
			return $query;
		}

		$allow_access = \Auth
			::user()
			->agents()
			->where('model_type', get_class($this))
			->where('ability_id', $ability)
			->pluck('model_id')
			->toArray();

		return $query->whereIn('id', $allow_access);

	}
}