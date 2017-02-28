<?php

namespace Chunker\Base\Commands;

use Illuminate\Console\Command;
use Storage;

/**
 * Команда для инициализации пакетов Chunker
 *
 * При указании опции --clean выполняется только удаление ненужных файлов
 *
 * По умолчанию выполнается:
 *      удаление ненужных файлов,
 *      публикация ассетов пакетов,
 *      переименование миграции медиафайлов,
 *      обновление кеша автозагрузки классов,
 *      добавление в .gitignore папки с компонентами bower,
 *      миграция.
 *
 * @package Chunker\Base\Commands
 */
class Init extends Command
{
	/** @var string команда для консоли */
	protected $signature = 'chunker:init
		{--clean : Only delete unnecessary files}';
	/** @var string описание команды */
	protected $description = 'Initialization of the Chunker';


	protected $ignored_path = [
		'/bower_components',
		'/public/media',
		'/storage/backups/',
		'/storage/laravel-backups/'
	];


	protected function addLine($contents, $line) {
		if (mb_strpos($contents, PHP_EOL . $line) === false) {
			$contents .= PHP_EOL . $line;
		}

		return $contents;
	}


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

			// Обновление кеша автозагрузки классов
			`composer dump-autoload`;

			// Добавление в .gitignore необходимых файлов
			if ($disk->exists('.gitignore')) {
				$contents = $disk->get('.gitignore');
				$contents = trim($contents);

				foreach ($this->ignored_path as $ignored_path) {
					$contents = $this->addLine($contents, $ignored_path);
				}

				$disk->put('.gitignore', $contents);

				$this->info('.gitignore modified');
			}

			// Миграция
			$this->call('migrate');
		}
	}
}