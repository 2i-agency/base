<?php

namespace Chunker\Base\Models\Traits;

use Illuminate\Database\Eloquent\Model;

/**
 * Трейт для проверки связи с с моделью
 *
 * @package Chunker\Base\Models\Traits
 */
trait IsRelatedWith
{
	/**
	 * Проверка связи с моделью
	 *
	 * @param string $relation имя связи
	 * @param mixed  $id ключ или модель для которых необходимо проверить существование связи
	 *
	 * @return bool
	 */
	public function isRelatedWith($relation, $id){
		// Если связи не настроена, то её и нет
		if (!method_exists($this, $relation)) {
			return false;
		}

		// Подготовка ключа
		if ($id instanceof Model) {
			$id = $id->getKey();
		}

		// Проверка связи
		return (bool)$this->$relation->find($id);
	}
}