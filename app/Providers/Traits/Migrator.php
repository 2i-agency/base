<?php
namespace Chunker\Base\Providers\Traits;


use Carbon\Carbon;

trait Migrator
{
	/**
	 * Убираем из названия файла порядковый номер
	 *
	 * @param string $file имя фала
	 *
	 * @return string
	 */
	protected function dropCount(string $file):string {
		return implode('_', array_slice(explode('_', $file), 1));
	}

	/**
	 * Получаем название класса миграции
	 *
	 * @param string $file имя файла
	 *
	 * @return string
	 */
	protected function getMigrateClassName(string $file):string {
		/** Избавляемся от расширений */
		$file = drop_extension($file);
		/** Преобразуем название файла в название класса */
		$class_name = studly_case($this->dropCount($file));

		return $class_name;
	}

	/**
	 * Публикация миграции
	 *
	 * @param string      $path путь до папки с миграциями
	 * @param string|NULL $group группа в которую публикуются миграции
	 */
	protected function upMigrates(string $path, string $group = NULL) {
		/** Получаем список файлов миграции */
		$files = array_slice(scandir($path), 2);

		$timestamp = Carbon::now()->addSecond();

		foreach ($files as $key => $file) {
			/** Если класса миграции не объявлен */
			if (!class_exists($this->getMigrateClassName($file))) {
				$time_name = $timestamp->addSeconds($key)->format('Y_m_d_His');

				$this->publishes([
					$path . $file => database_path('migrations/' . $time_name . '_' . $this->dropCount(drop_extension($file, true))),
				], is_null($group) ? 'migrations' : $group);

				$timestamp->subSeconds($key);
			}

		}
	}
}