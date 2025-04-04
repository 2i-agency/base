<?php

namespace Chunker\Base\Models\Traits;

use DB;
use Illuminate\Database\Eloquent\Model;

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
		$is_slug = \Schema::hasColumn($this->getTable(), 'slug');

		if ($is_slug) {

			if (
				isset($this->field_config) &&
				(
					is_string($this->field_config) && config($this->field_config) ||
					is_bool($this->field_config) && $this->field_config
				)
			) {
				return 'slug';
			} elseif(!isset($this->field_config)) {
				throw new \Error(self::getErrorMessage('field_config'));
			}

		}

		return $this->getKeyName();
	}


	/**
	 * Метод выполняющийся при загрузке трейта
	 */
	protected static function bootSlugs() {
		self::saving(function(Model $instance) {
			if (isset($instance->fields_donor)) {

				$is_slug = (bool)DB
					::table('information_schema.COLUMNS')
					->select('*')
					->where('TABLE_SCHEMA', env('DB_DATABASE'))
					->where('TABLE_NAME', $instance->getTable())
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
							$slug = $instance->getAttribute($instance->fields_donor);
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
							$query = sprintf('SHOW TABLE STATUS FROM `%s` LIKE \'%s\'', env('DB_DATABASE'), $instance->getTable());
							$result = DB::select($query);
							$id = array_first($result)->Auto_increment;
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