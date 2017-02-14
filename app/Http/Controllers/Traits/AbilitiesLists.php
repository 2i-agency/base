<?php

namespace Chunker\Base\Http\Controllers\Traits;


use Chunker\Base\Models\Ability;
use Chunker\Base\Models\User;

trait AbilitiesLists
{
	protected function addAbbilities($abilities, $add_abilities) {

		if ($abilities->count()) {
			foreach ($add_abilities as $add_ability) {
				if (!$abilities->contains($add_ability)) {
					$abilities->push($add_ability);
				}
			}
		} else {
			$abilities = $add_abilities;
		}

		return $abilities;
	}


	protected function getAbilities($agent) {
		$abilities = $agent->abilities()->pluck('id');
		$add_abilities = collect();

		if ($agent instanceof User) {
			$roles = $agent->roles()->get();
			foreach ($roles as $role) {
				$add_abilities = $this->addAbbilities($add_abilities, $role->abilities()->pluck('id'));
			}
			$abilities = $this->addAbbilities($abilities, $add_abilities);
		}

		return $abilities;
	}

	protected function getEnabledAbilities() {

		$abilities = $this->getAbilities(request()->user());

		$enabled = collect();
		foreach ($abilities as $ability) {
			if (Ability::detectNamespace($ability) . '.edit' == $ability){
				$enabled->push(Ability::detectNamespace($ability));
			}
		}

		return $enabled;
	}
}