<?php

namespace Chunker\Base\Models\Traits;

/**
 * Трейт для работы со слагами
 *
 * @package Chunker\Base\Models\Traits
 */
trait Slugs
{
	/**
	 * Метод для возврата текста ошибки.
	 * Используется при генерации исключений в данном трейте
	 *
	 * @param string $attribute название атрибута модели
	 *
	 * @return string текст сообщения
	 */
	protected static function getErrorMessage($attribute) {
		$class_name = __CLASS__;
		$class_name = array_last(explode('\\', $class_name));

		return 'В модели ' . $class_name . ' (' . __CLASS__ . ') ' . ' отсутствует свойство ' . $attribute;
	}


	/**
	 * Подменяет собой метод по умолчанию.
	 * Необходимо для корректого возврашения имени ключа для роута
	 *
	 * @return string имя ключа
	 *
	 * @throws \Error
	 */
	public function getRouteKeyName() {
		$is_slug = \Schema::hasColumn($this->table, 'slug');

		if ($is_slug) {

			if (isset($this->field_config)) {

				if (config($this->field_config)) {
					return 'slug';
				}

			} else {
				throw new \Error(self::getErrorMessage('field_config'));
			}

		}
	}


	/**
	 * Метод выполняющийся при загрузке трейта
	 */
	protected static function bootSlugs() {
		self::saving(function($instance) {
			if (isset($instance->fields_donor)) {

				$is_slug = (bool)\DB
					::table('information_schema.COLUMNS')
					->select('*')
					->where('TABLE_SCHEMA', env('DB_DATABASE'))
					->where('TABLE_NAME', $instance->table)
					->where('COLUMN_NAME', 'slug')
					->count();

				if ($is_slug) {

					$slug = NULL;
					$attributes = $instance->getAttributes();

					if (isset($attributes[ 'slug' ]) && strlen($attributes[ 'slug' ])) {
						$slug = $attributes[ 'slug' ];
					}

					if (!is_string($slug) || !strlen($slug)) {

						if (is_string($instance->fields_donor)) {
							$slug = $attributes[ $instance->fields_donor ];
						} else {
							foreach ($instance->fields_donor as $field_donor) {
								if (strlen($instance->getAttribute($field_donor))) {
									$slug = $instance->getAttribute($field_donor);
									break;
								}
							}
						}

						if ($instance->id) {
							$id = $instance->id;
						} else {
							$id = array_first(
								\DB::select(
									'SHOW TABLE STATUS FROM `'
									. env('DB_DATABASE')
									. '` LIKE \''
									. $instance->table
									. '\''
								)
							)->Auto_increment;
						}

						$slug = $id . '-' . $slug;

					}

					if (is_null($slug)) {
						$class_name = __CLASS__;
						$class_name = array_last(explode('\\', $class_name));
						throw new \Error('Поле slug не может быть null. Модель ' . $class_name . ' (' . __CLASS__ . ') ');
					}

					$instance->slug = str_slug($slug);
				}

			} else {
				throw new \Error(self::getErrorMessage('fields_donor'));
			}
		});
	}
}