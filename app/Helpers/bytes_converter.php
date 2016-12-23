<?php

/**
 * Хелпер для преобразования байт в КБ, МБ, ГБ, ТБ
 *
 * При отсутствии второго параметра результат возвращается в максимально возможном большем 1
 *
 * @param string $bytes
 * @param string $format = null указывает на конкретные единицы измерения ('B', 'KB', 'MB', 'GB', 'TB')
 *
 * @return string
 */
function bytes_convert($bytes, $format = NULL){
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

	return round($bytes / $size) . ' ' . $format;
}