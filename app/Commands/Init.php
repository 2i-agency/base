<?php

namespace Chunker\Base\Commands;

use Chunker\Base\Models\Language;
use Illuminate\Console\Command;
use Storage;

class Init extends Command
{
	protected $signature = 'chunker:init
		{--clean : Only delete unnecessary files}
		{--seed : Only data seed}';
	protected $description = 'Initialization of the Chunker';


	public function handle() {
		// Выполняются не все действия
		$only = false;
		foreach (['clean', 'seed'] as $option) {
			if ($this->option($option)) {
				$only = true;
				break;
			}
		}


		// Диск для работы с файлами проекта
		$disk = Storage::createLocalDriver(['root' => base_path()]);


		// Удаление ненужных файлов
		if (!$only || $this->option('clean')) {
			if ($disk->delete([
				// Коробочные миграции и модели
				'database/migrations/2014_10_12_000000_create_users_table.php',
				'database/migrations/2014_10_12_100000_create_passwords_resets_table.php',
				'app/User.php'
			])
			) {
				$this->warn('Deleted unnecessary files');
			};
		}


		// Публикация ассетов пакетов
		if (!$only) {
			$this->call('vendor:publish', ['--force' => true]);
		}


		// Оптимизация (необходимо для обновления кеша автозагрузки классов)
		if (!$only) {
			$this->call('optimize');
		}


		// Миграция
		if (!$only) {
			$this->call('migrate');
		}


		// Посев
		if (!$only || $this->option('seed')) {
			$this->call('db:seed', ['--class' => 'UsersSeeder']);
			$this->call('db:seed', ['--class' => 'AbilitiesSeeder']);
			$this->call('db:seed', ['--class' => 'LanguagesSeeder']);
			$this->call('db:seed', ['--class' => 'SettingsSeeder']);
			$this->line('Data were sown');
		}
	}
}