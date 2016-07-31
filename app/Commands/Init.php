<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;
use Storage;

class Init extends Command
{
	protected $description = 'Initialization of the Chunker';
	protected $signature = 'chunker:init
		{--clean : Only delete unnecessary files}';


	public function handle() {
		// Выполняются не все действия
		$only = false;

		foreach (['clean'] as $option) {
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


		// Обновление кеша автозагрузки классов
		if (!$only) {
			system('composer dump-autoload');
		}


		// Миграция
		if (!$only) {
			$this->call('migrate');
		}
	}
}