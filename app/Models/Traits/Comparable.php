<?php

namespace Chunker\Base\Models\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Трейт для сравнения двух моделей на идентичность
 *
 * @package Chunker\Base\Models\Traits
 */
trait Comparable
{
	/**
	 * Сравнение с другой моделью
	 *
	 * @param Model $model
	 *
	 * @return bool
	 */
	public function is(Model $model){
		$is_class_equivalent = get_class($this) == get_class($model);
		$is_key_equivalent = $this->getKey() == $model->getKey();

		return $is_class_equivalent && $is_key_equivalent;
	}
}