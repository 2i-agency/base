<?php

use Chunker\Base\Models\Notice;
use Chunker\Base\Models\NoticesType;
use Chunker\Base\Models\Setting;


if (!function_exists('bytes_convert')) {
	/**
	 * Хелпер для преобразования байт в КБ, МБ, ГБ, ТБ
	 *
	 * При отсутствии второго параметра результат возвращается в максимально возможном большем 1
	 *
	 * @param string $bytes
	 * @param string $format указывает на конкретные единицы измерения ('B', 'KB', 'MB', 'GB', 'TB')
	 *
	 * @return string
	 */
	function bytes_convert(string $bytes, string $format = NULL):string {
		$base = 1024;
		$units = [ 'B', 'KB', 'MB', 'GB', 'TB' ];

		if (is_null($format)) {
			for ($i = count($units) - 1; $i >= 0; $i--) {
				$size = pow($base, $i);
				$format = $units[ $i ];
				if ($bytes > $size) {
					break;
				}
			}
		} else {
			$format = mb_strtoupper($format, 'UTF-8');
			$exp = array_search($format, $units);
			$size = pow($base, $exp);
		}

		return sprintf('%d %s', round($bytes / $size), $format);
	}
}


if (!function_exists('drop_extension')) {
	/**
	 * Отбрасываем расширения из имени файла
	 *
	 * @param string $name имя файла
	 * @param bool   $last указывает, отбрасывать все расширения или только последнее
	 *
	 * @return string
	 */
	function drop_extension(string $name, $last = false):string {
		if ($last) {
			$first_extension = array_last(explode('.', $name));

			return implode('.', array_diff(explode('.', $name), [ $first_extension ]));
		} else {
			return array_first(explode('.', $name));
		}
	}
}


if (!function_exists('get_max_filesize')) {
	function get_max_filesize() {
		$post_max_size = ini_get('post_max_size');
		$upload_max_filesize = ini_get('upload_max_filesize');
		$memory_limit = ini_get('memory_limit');

		$max_size = get_size($post_max_size);
		$upload_max_filesize = get_size($upload_max_filesize);
		$memory_limit = get_size($memory_limit);

		if ($upload_max_filesize < $max_size) {
			$max_size = $upload_max_filesize;
		}

		if ($memory_limit < $max_size) {
			$max_size = $memory_limit;
		}

		return $max_size;

	}
}


if (!function_exists('get_size')) {
	function get_size($val) {
		$val = trim($val);
		$last = strtolower($val[ strlen($val) - 1 ]);
		$val = (int)$val;
		switch ($last) {
			case 'g':
				$val *= 1024;
			case 'm':
				$val *= 1024;
			case 'k':
				$val *= 1024;
		}

		return $val;
	}
}


if (!function_exists('host')) {
	/**
	 * Возвращает хост сайта на основании конфигурации
	 *
	 * @return string
	 */
	function host() {
		$url_data = parse_url(config('app.url'));

		if (key_exists('host', $url_data)) {
			return $url_data[ 'host' ];
		}

		return $url_data[ 'path' ];
	}
}


if (!function_exists('name_generator')) {
	/**
	 * Создание случайного имени для файлов
	 *
	 * @param string $definition
	 *
	 * @return string
	 */
	function name_generator($definition = NULL) {
		$name = time() . '-' . md5(rand(0, 999999999999));

		if (!is_null($definition)) {
			$extension = mb_strtolower($definition);
			preg_match('/[\w]+$/', $extension, $extension);
			$extension = $extension[ 0 ];
			$name .= '.' . $extension;
		}

		return $name;
	}
}


if (!function_exists('notice')) {
	/**
	 * Добавление уведомления администратора
	 *
	 * @param string $content
	 * @param string|NoticesType|int|null $type
	 * @param array|null $users_ids
	 */
	function notice($content, $type = NULL, array $users_ids = NULL) {
		if (is_object($type)) {
			$type = $type->id;
		} elseif (is_string($type)) {
			$type = NoticesType::where('tag', $type)->first([ 'id' ])->id;
		} elseif ($type) {
			$type = (int)$type;
		}

		$attributes = [
			'content' => $content,
			'type_id' => $type,
		];

		$notice = new Notice($attributes);

		if (isset($users_ids) && count($users_ids)) {
			$notice->users_ids = $users_ids;
		}

		$notice->save();
	}
}


if (!function_exists('require_routes')) {
	/**
	 * Подключает роуты, находящиеся в папке, путь до которой передан параметром
	 *
	 * @param string $path путь до папки с роутами
	 */
	function require_routes($path) {
		if (is_dir($path)) {
			$files = array_slice(scandir($path), 2);

			foreach ($files as $file) {
				require_once $path . $file;
			}
		}
	}
}


if (!function_exists('setting')) {
	/**
	 * Получение значения настройки
	 *
	 * @param      $id
	 * @param      $default
	 *
	 * @return null|string
	 */
	function setting($id, $default = NULL) {
		if (Schema::hasTable('base_settings')) {
			$setting = Setting::find($id);

			return $setting && !empty($setting->value) ? $setting->value : $default;
		}

		return NULL;
	}
}