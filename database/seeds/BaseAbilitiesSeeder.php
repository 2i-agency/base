<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Ability;

/**
 * Посев возможностей
 */
class BaseAbilitiesSeeder extends Seeder
{
	public function run(){
		foreach (app()[ 'Packages' ]->getAbilities() as $id => $name) {
			if (!Ability::find($id)) {
				Ability::create([
					'id'   => $id,
					'name' => $name
				]);
			}
		}
	}
}