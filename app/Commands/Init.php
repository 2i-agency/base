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
				'database/migrations/2014_10_12_100000_create_password_resets_table.php',
				'app/User.php'
			])
			) {
				$this->warn('Deleted unnecessary files');
			};
		}


		if (!$only) {
			// Публикация ассетов пакетов
			$this->call('vendor:publish', ['--force' => true]);

			// Переименование миграции медиафайлов
			$media_migration_search_results = glob(database_path('migrations/*_create_media_table.php'));

			if ($media_migration_search_results) {
				$media_migration_filename = $media_migration_search_results[0];
				$new_media_migration_filename = 'migrations/2016_00_00_000000_create_media_table.php';
				rename(
					$media_migration_filename,
					database_path($new_media_migration_filename));
			}

			// Обновление кеша автозагрузки классов
			`composer dump-autoload`;

			// Добавление в .gitignore папки с компонентами bower
			if ($disk->exists('.gitignore')) {
				$contents = $disk->get('.gitignore');
				$contents = trim($contents);
					if(mb_strpos($contents, PHP_EOL . '/bower_components') === false) {
						$contents .= PHP_EOL . '/bower_components' . PHP_EOL;
					}
				$disk->put('.gitignore', $contents);
			}

			// Миграция
			$this->call('migrate');
		}
	}
}