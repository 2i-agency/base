<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Language;

/**
 * Посев языков
 */
class BaseLanguagesTestSeeder extends Seeder
{
	/**
	 * Метод, возвращающий путь до файла иконки или NULL если иконки нет.
	 * При генерации локали может создаваться не существующая локаль
	 *
	 * @param string $locale локаль, по которой будет искаться иконка
	 *
	 * @return string|null
	 */
	protected function getIcon($locale){
		// Получаем файл (предположительно с иконкой)
		\Storage::put(
			'lang_icons/' . $locale . '.gif',
			@file_get_contents('http://www.geonames.org/flags/x/' . $locale . '.gif')
		);

		// Узнаём тип файла
		$type = \File::mimeType(storage_path('app/lang_icons/' . $locale . '.gif'));

		// Если gif, то возвращаем путь до иконки
		if ($type == 'image/gif'){
			return storage_path('app/lang_icons/' . $locale . '.gif');
		}
	}


	public function run(){

		$multi = config('chunker.localization.multi');
		$is_icon = config('chunker.localization.icon.using');
		$count = rand(1, 5);

		// Очищаем таблицу
		Language::truncate();

		// Делаем посев русского языка
		$this->call(BaseLanguagesSeeder::class);

		// Если иконки разрешены, то добавляем иконку для русского языка
		if ($multi && $is_icon) {
			Language::first()->addMedia($this->getIcon('ru'))
				->setFileName('original.gif')
				->toCollection('language.icon');
		}

		// Если включен режим мультиязычности, то генерим ещё несколько языков
		if ($multi) {
			factory(Language::class, $count)
				->create()
				->each(function($lang) use ($is_icon) {
					$icon = $this->getIcon($lang->locale);

					if ($is_icon && $icon) {
						/** Добавить новую иконку */
						$lang->addMedia($icon)
							->setFileName('original.gif')
							->toCollection('language.icon');
					}
				});
		}

		\Storage::deleteDirectory('lang_icons');

	}
}