<?php

namespace Chunker\Base\Models\Traits;

trait HasNullAttributes
{
	/*
	 * Set null if value not contains meaning chars
	 */
	protected function nullingAttribute($attribute, $value)
	{
		return $this->attributes[$attribute] = strlen(trim($value)) ? $value : NULL;
	}
}