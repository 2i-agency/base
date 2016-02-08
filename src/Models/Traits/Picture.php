<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Helpers\FilenameGenerator;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Storage;
use Closure;
use Image;

trait Picture
{
	/*
	 * Получение конфигурации изображения
	 */
	protected function getPictureConfig($field)
	{
		// Подготовка основы из существующей конфигурации
		if (property_exists($this, 'pictures') && array_has($this['pictures'], $field))
		{
			$config = $this['pictures'][$field];
		}
		// Подготовка чистой основы
		else
		{
			$config = [];
		}


		// Подготовка пути к папке
		$directory = $this->picturesDirectory . '/';
		$directory .= $config['directory'] ?: NULL;
		$config['directory'] = trim($directory, '/');


		// Подготовка типа
		$config['type'] = array_has($config, 'type') ? $config['type'] : IMAGETYPE_PNG;


		// Подготовка расширения
		$config['extension'] = ltrim(image_type_to_extension($config['type']), '.');


		return $config;
	}


	/*
	 * Генерация нового имени файла
	 */
	protected function makePictureFilename($field)
	{
		$config = $this->getPictureConfig($field);
		return FilenameGenerator::make($config['extension']);
	}


	/*
	 * Получение диска для работы с папкой
	 */
	protected function makePictureDisk($field)
	{
		$config = $this->getPictureConfig($field);
		return Storage::createLocalDriver(['root' => public_path($config['directory'])]);
	}


	/*
	 * Применение трансформации
	 */
	protected function doTransform($field, Closure $callback = NULL)
	{
		if (!is_null($callback))
		{
			$filename = $this->getPictureConfig($field)['directory'] . '/' . $this[$field];
			$picture = Image::make($filename);
			$callback($picture);
			$picture->save($filename);
		}
	}


	/*
	 * Удаление файла изображения
	 */
	public function deletePicture($field)
	{
		$disk = $this->makePictureDisk($field);
		$filename = $this[$field];

		if (!is_null($filename) && $disk->has($filename))
		{
			$disk->delete($filename);
		}

		$this->attributes[$field] = NULL;


		return $this;
	}


	/*
	 * Сохранение загруженного изображения
	 */
	public function uploadPicture(UploadedFile $file, $field, Closure $transform = NULL)
	{
		// Если файл загружен с ошибкой, то ничего делать не нужно
		if (!$file->isValid())
		{
			return false;
		}

		// Удаление старого изображения
		$this->deletePicture($field);

		// Сохранение изображения
		$filename = $this->makePictureFilename($field);
		$this->attributes[$field] = $filename;
		$file->move($this->getPictureConfig($field)['directory'], $filename);

		// Трансформирование
		$this->doTransform($field, $transform);


		return $this;
	}


	/*
	 * Копирование изображения
	 */
	public function copyPicture($fromField, $toField, Closure $transform = NULL)
	{
		// Удаление старого изображения
		$this->deletePicture($toField);

		// Сохранение копии изображения
		$filename = $this->makePictureFilename($toField);
		$this->attributes[$toField] = $filename;

		$content = $this
			->makePictureDisk($fromField)
			->get($this[$fromField]);

		$this->makePictureDisk($toField)
			->put($filename, $content);

		// Трансформирование
		$this->doTransform($toField, $transform);


		return $this;
	}


	/*
	 * Получение ссылки на изображение
	 */
	public function getPictureUrl($field)
	{
		return $this->getPictureConfig($field)['directory'] . '/' . $this[$field];
	}


	/*
	 * Получение полей, связанных с изображениями
	 */
	public function getPicturesFields()
	{
		$fields = [];

		foreach ($this->pictures as $key => $value)
		{
			$fields[] = is_array($value) ? $key : $value;
		}

		return $fields;
	}
}