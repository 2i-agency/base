<?php

namespace Chunker\Base\Libs;

/**
 * Клас методов для работы с конверсиями
 *
 * @package Chunker\Base\Libs
 */
class ConversionsManager
{
	/**
	 * Метод возвращающий массив параметров конверсий
	 *
	 * @param string $name - название шаблона конверсии
	 *
	 * @return array
	 */
	public static function getConversion($name){
		/** @var array $conversions массив шаблонов конверсии */
		$conversions = config('chunker.conversions.templates');
		/** @var array $default массив с параметрами по умолчанию */
		$default = array_pull($conversions, 'default');

		if (is_null($default)) {
			$default = [];
		}

		return array_merge($default, $conversions[ $name ]);
	}

	/**
	 * Метод возвращающий список конверсий с их параметрами.
	 *
	 * @param string $conversions_config путь до конфига со списокм конверсий
	 *
	 * @return array
	 */
	public static function getConversionsList($conversions_config){

		// Если список конверсий определён, то брать его, иначе брать список всех конверсий
		if (isset($conversions_config)) {
			$conversions = config($conversions_config);
		} else {
			$conversions = config('chunker.conversions.templates');
			$conversions = array_except($conversions, 'default');
		}

		// переменная, хранящая список всех манипуляций
		$manipulations = [];

		foreach ($conversions as $key => $conversion) {
			if (is_int($key)) {
				$manipulations[ $conversion ] = self::getConversion($conversion);
			} else {
				$manipulations[ $key ] = $conversion;
			}
		}

		return $manipulations;
	}
}