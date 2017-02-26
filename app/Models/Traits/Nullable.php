<?php

namespace Chunker\Base\Models\Traits;

/**
 * Трейт для обнуления полей nullable при сохранении модели
 *
 * @package Chunker\Base\Models\Traits
 */
trait Nullable
{
	/**
	 * Обнуление атрибутов при сохранении
	 */
	public static function bootNullable(){
		static::saving(function($model){
			if (property_exists($model, 'nullable')) {
				foreach ($model->nullable as $field) {
					if (!mb_strlen(trim($model->{$field}))) {
						$model->{$field} = NULL;
					}
				}
			}
		});
	}
}