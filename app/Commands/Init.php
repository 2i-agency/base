<?php

namespace Chunker\Base\Commands;

use Chunker\Base\Models\Language;
use Illuminate\Console\Command;
use Storage;

class Init extends Command
{
	protected $signature = 'chunker:init';
	protected $description = 'Initialization of the Chunker';


	public function handle() {
		// Диск для работы с файлами проекта
		$disk = Storage::createLocalDriver(['root' => base_path()]);


		// Удаление ненужных файлов
		if ($disk->delete([
			// Коробочная миграция таблицы пользователей
			'database/migrations/2014_10_12_000000_create_users_table.php',

			// Коробочная модель пользователя
			'app/User.php'
		])
		) {
			$this->line('Deleted unnecessary files');
		};


		// Публикация ассетов пакетов
		$this->call('vendor:publish', ['--force' => true]);


		// Миграция и заполнение таблиц
		$this->call('migrate');
		$this->call('db:seed', ['--class' => 'UsersSeeder']);
		$this->call('db:seed', ['--class' => 'LanguagesSeeder']);
	}
}