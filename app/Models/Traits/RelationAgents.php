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

		foreach (\Auth::user()->roles()->get() as $role) {
			$ids = $role->agents()
				->where('model_type', get_class($this))
				->where('ability_id', 'like', '%' . Ability::detectNamespace($ability) . '%')
				->pluck('model_id')
				->toArray();

			$allow_access = array_merge($allow_access, $ids);
		}

		$disallow_access = \Auth
			::user()
			->agents()
			->where('model_type', get_class($this))
			->whereNull('ability_id')
			->pluck('model_id')
			->toArray();

		foreach (\Auth::user()->roles()->get() as $role) {
			$ids = $role
				->agents()
				->where('model_type', get_class($this))
				->whereNull('ability_id')
				->pluck('model_id')
				->toArray();

			$disallow_access = array_merge($disallow_access, $ids);
		}

		if (\Auth::user()->id == 1) {
			return $query;
		}

		if (\Auth::user()->hasAccess($ability, false)) {
			return $query->whereNotIn('id', $disallow_access);
		} else {
			return $query->whereIn('id', $allow_access);
		}

	}
}