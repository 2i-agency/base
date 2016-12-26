<?php

namespace Chunker\Base\Models\Traits;

use Carbon\Carbon;

/**
 * Трейт для парсинга времени и записи его в атрибут модели
 *
 * @package Chunker\Base\Models\Traits
 */
trait HasDates
{
	/**
	 * Парсинг времени перед установкой в качестве атрибута
	 *
	 * @param string $field поле, в которое будет записано значение
	 * @param string $time
	 */
	protected function prepareTime($field, $time){
		$this->attributes[ $field ] = strlen($time) ? Carbon::parse($time) : NULL;
	}
}