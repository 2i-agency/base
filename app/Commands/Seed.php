<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;

class Seed extends Command
{
	protected $description = 'Seeding data for Chunker';
	protected $signature = 'chunker:seed
		{--package : Seeding data only for one package}';

	protected $seeders = [
		'SettingsSeeder',
		'AbilitiesSeeder',
		'LanguagesSeeder',
		'UsersAndRolesSeeder'
	];


	public function handle() {
		if (count($this->seeders)) {
			foreach ($this->seeders as $seeder) {
				$this->call('db:seed', ['--class' => $seeder]);
			}

			$this->line('Data were sown');
		}
	}
}