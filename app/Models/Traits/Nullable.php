<?php

namespace Chunker\Base\Models\Traits;

trait Nullable
{
	/*
	 * Обнуление атрибутов при сохранении
	 */
	public static function bootNullable() {
		static::saving(function($model) {
			if (property_exists($model, 'nullable')) {
				foreach ($model->nullable as $field) {
					if (empty($model->{$field})) {
						$model->{$field} = null;
					}
				}
			}
		});
	}
}