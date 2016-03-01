<?php

namespace Chunker\Base\Helpers;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilenameGenerator
{
	/*
	 * Генерация имени файла.
	 * Параметр `definition` влияет на результат следующим образом:
	 * - строка воспринимается как расширение
	 * - объект класса UploadedFile предоставляет расширение
	 */
	static public function make($definition = NULL)
	{
		$name = time() . '-' . md5(rand(0, 999999999999));

		if (!is_null($definition))
		{
			// Получение расширения по объекту загруженного файла
			if (is_object($definition) && get_class($definition) == UploadedFile::class)
			{
				$extension = $definition->guessExtension();
			}
			// Расширение из переданного определения
			else
			{
				$extension = mb_strtolower($definition);
			}

			$name .= '.' . $extension;
		}


		return $name;
	}
}