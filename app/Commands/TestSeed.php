<?php

namespace Chunker\Base\Commands;

use Chunker\Base\Models\Media;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Команда для посева данных в БД
 *
 * @package Chunker\Base\Commands
 */
class TestSeed extends Command
{
	/** @var string конамда для консоли */
	protected $signature = 'chunker:test-seed';
	/** @var string описание команды */
	protected $description = 'Посев тестовых данных для пакетов Chunker';


	public function handle() {
		// Проверяем окружение
		if (!env('APP_DEBUG')) {
			$this->error('Проект в продакшне! Тестовый посев невозможен.');
			return false;
		}

		// Предупреждаем об очистке БД
		if (!$this->confirm('База данных будет очищена. Вы действительно хотите продожить?')) {
			return false;
		}

		// Чистим таблицы
		Media::truncate();
		\DB::table('activity_log')->truncate();
		\DB::table('base_authentications')->truncate();

		// Собираем классы посевщиков
		$seeders = app()
			->make('Packages')
			->getTestSeeders();

		// Сеям тестовые данные
		if (count($seeders)) {
			foreach ($seeders as $seeder) {
				$this->callSilent('db:seed', [ '--class' => $seeder ]);
				$this->line('<info>Посеяны: </info>' . $seeder);
			}

			$this->info('Все данные посеяны.');
		}

		return true;
	}
}