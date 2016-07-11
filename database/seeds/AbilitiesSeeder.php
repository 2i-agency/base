<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Ability;

class AbilitiesSeeder extends Seeder
{
	public function run() {
		foreach (app()['Packages']->getAbilities() as $id => $name) {
			Ability::create([
				'id'    => $id,
				'name'  => $name
			]);
		}
	}
}