<?php

namespace Chunker\Base\Models\Traits;

use Illuminate\Database\Eloquent\Model;

trait IsRelatedWith
{
	/*
	 * Проверки связи с моделью
	 */
	public function isRelatedWith($relation, $id) {
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