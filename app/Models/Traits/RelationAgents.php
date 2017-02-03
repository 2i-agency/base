<?php
namespace Chunker\Base\Models\Traits;

use Chunker\Base\Models\Ability;
use Chunker\Base\Models\Agent;

trait RelationAgents
{
	public function agents() {
		return $this->morphMany(Agent::class, 'model');
	}

	public function ScopeOnlyAccess($query, $ability) {
		$allow_access = \Auth
			::user()
			->agents()
			->where('model_type', get_class($this))
			->where('ability_id', 'like', '%' . Ability::detectNamespace($ability) . '%')
			->pluck('model_id')
			->toArray();

		if (
			(
				(\Auth::user()->id == 1)
				|| \Auth::user()->hasAccess($ability, false)
			)
			&& !\Auth
				::user()
				->agents()
				->whereNull('ability_id')
				->count()
		) {
			return $query;
		} else {
			return $query->whereIn('id', $allow_access);
		}


	}
}