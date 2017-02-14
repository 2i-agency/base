<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;

/**
 * Команда для посева данных в БД
 *
 * @package Chunker\Base\Commands
 */
class Seed extends Command
{
	/** @var string конамда для консоли */
	protected $signature = 'chunker:seed
		{--package : Seeding data only for one package}';
	/** @var string описание команды */
	protected $description = 'Seeding data for Chunker';


	public function handle(){
		$seeders = app()
			->make('Packages')
			->getSeeders();

		if (count($seeders)) {
			foreach ($seeders as $seeder) {
				$this->call('db:seed', [ '--class' => $seeder ]);
			}

			$this->line('Data were sown');
		}
	}
}