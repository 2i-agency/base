<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;
use Storage;

/**
 * Class Init. Команда для инициализации пакетов Chunker
 *
 * При указании опции --clean выполняется только удаление ненужных файлов
 *
 * По умолчанию выполнается:
 *      удаление ненужных файлов;
 *      публикация ассетов пакетов;
 *      переименование миграции медиафайлов;
 *      обновление кеша автозагрузки классов;
 *      добавление в .gitignore папки с компонентами bower;
 *      миграция.
 *
 * @package Chunker\Base\Commands
 */
class Init extends Command
{
	protected $signature = 'chunker:init
		{--clean : Only delete unnecessary files}';
	protected $description = 'Initialization of the Chunker';


	public function handle(){

		// Флаг выполнения всех действий
		$do_all_actions = true;

		// Поиск переданных опций
		foreach ([ 'clean' ] as $option) {
			if ($this->option($option)) {
				$do_all_actions = false;
				break;
			}
		}

		// Диск для работы с файлами проекта
		$disk = Storage::createLocalDriver([ 'root' => base_path() ]);

		// Удаление ненужных файлов
		if ($do_all_actions || $this->option('clean')) {
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


		if ($do_all_actions) {
			// Публикация ассетов пакетов
			$this->call('vendor:publish', [ '--force' => true ]);

			// Переименование миграции медиафайлов
			$media_migration_search_results = glob(database_path('migrations/*_create_media_table.php'));

			if ($media_migration_search_results) {
				$media_migration_filename = $media_migration_search_results[ 0 ];
				$new_media_migration_filename = 'migrations/2016_00_00_000000_create_media_table.php';
				rename(
					$media_migration_filename,
					database_path($new_media_migration_filename));

				$this->info('Rename media migration');
			}

			// Обновление кеша автозагрузки классов
			`composer dump-autoload`;

			// Добавление в .gitignore папки с компонентами bower
			if ($disk->exists('.gitignore')) {
				$contents = $disk->get('.gitignore');
				$contents = trim($contents);
				if (mb_strpos($contents, PHP_EOL . '/bower_components') === false) {
					$contents .= PHP_EOL . '/bower_components' . PHP_EOL;
				}
				$disk->put('.gitignore', $contents);

				$this->info('.gitignore modified');
			}

			// Миграция
			$this->call('migrate');
		}
	}
}