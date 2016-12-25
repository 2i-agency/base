<?php

namespace Chunker\Base\Libs;

/**
 * Class ConversionsManager - Клас методов для работы с конверсиями
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

		if (is_null($default)){
			$default = [];
		}

		return array_merge($default, $conversions[$name]);
	}
}