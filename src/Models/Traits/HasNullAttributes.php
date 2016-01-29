<?php

namespace Chunker\Base\Models\Traits;

trait HasNullAttributes
{
	/*
	 * Установка NULL вместо пустой или пробельной строки
	 */
	protected function nullingAttribute($attribute, $value)
	{
		return $this->attributes[$attribute] = strlen(trim($value)) ? $value : NULL;
	}
}