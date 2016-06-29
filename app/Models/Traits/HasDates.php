<?php

namespace Chunker\Base\Models\Traits;

use Carbon\Carbon;

trait HasDates
{
	/*
	 * Парсинг времени перед установкой в качестве атрибута
	 */
	protected function prepareTime($field, $time) {
		$this->attributes[$field] = strlen($time) ? Carbon::parse($time) : NULL;
	}
}