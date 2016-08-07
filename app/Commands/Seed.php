<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;

class Seed extends Command
{
	protected $description = 'Seeding data for Chunker';
	protected $signature = 'chunker:seed
		{--package : Seeding data only for one package}';


	public function handle() {
		$seeders = app()
			->make('Packages')
			->getSeeders();
		
		if (count($seeders)) {
			foreach ($seeders as $seeder) {
				$this->call('db:seed', ['--class' => $seeder]);
			}

			$this->line('Data were sown');
		}
	}
}