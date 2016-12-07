<?php

namespace Chunker\Base\Models\Traits;

trait Slugs
{

	/*
	 * Метод для возврата текста ошибки
	 */
	protected static function getErrorMessage($attribute) {
		$class_name = __CLASS__;
		$class_name = array_last( explode('\\', $class_name) );
		return 'В модели ' . $class_name . ' (' . __CLASS__ . ') ' . ' отсутствует свойство ' . $attribute;
	}


	/*
	 * Метод, который должен быть вызван при сохранении модели
	 */
	public static function savingModel($instance) {

		if ( isset($instance->fields_donor) ) {

			if( isset($instance->slug) ) {

				$slug = null;
				$attributes = $instance->getAttributes();

				if ( strlen($attributes['slug']) ) {
					$slug = $attributes['slug'];
				}

				if ( !is_string($slug) || !strlen($slug) ) {

					if ( is_string($instance->fields_donor) ) {
						$slug = $attributes[$instance->fields_donor];
					} else {
						foreach ($instance->fields_donor as $field_donor) {
							if ( strlen($instance->getAttribute($field_donor)) ) {
								$slug = $instance->getAttribute($field_donor);
								break;
							}
						}
					}

				}

				$instance->slug = str_slug($slug);
			}

		} else {
			throw new \Error(self::getErrorMessage('fields_donor'));
		}

	}


	public function getRouteKeyName()
	{
		$is_slug = \Schema::hasColumn($this->table, 'slug');

		if ($is_slug) {

			if ( isset($this->field_config) ) {

				if( config($this->field_config) ) {
					return 'slug';
				}

			} else {
				throw new \Error(self::getErrorMessage('field_config'));
			}

		}
	}


}