<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Ability;

class AbilitiesSeeder extends Seeder
{
	public function run() {
		// Зарегистрированные пакеты
		$packages = app()->make('Packages')->getPackages();

		// Добавление возможностей
		foreach ($packages as $package) {
			foreach ($package->getAbilities() as $ability_id => $ability_name) {
				Ability::create([
					'id'    => $ability_id,
					'name'  => $ability_name
				]);
			}
		}
	}
}