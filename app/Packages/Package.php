<?php

namespace Chunker\Base\Packages;

/*
 * Описание пакета Chunker
 */

class Package
{
	// Название пакета
	protected $name;

	// Возможности
	protected $abilities = [];

	// Представления для редактирования возможностей
	protected $abilitiesViews = [];

	// Посевщики
	protected $seeders = [];


	/*
	 * Доступ к свойствам, установка свойств базового типа, регистрация данных в свойствах-массивах
	 */
	public function __call($method, $arguments) {
		// Возможные действия
		$actions = [
			'get',
			'register',
			'set'
		];


		// Определение действия и названия свойства
		foreach ($actions as $action) {
			if (starts_with($method, $action)) {
				$property = camel_case(substr($method, mb_strlen($action)));
				break;
			}
		}


		// Если свойство не определено, то и не определено и действие.
		// Свойство также может не существовать
		if (!isset($property) || !property_exists($this, $property)) {
			return NULL;
		}


		// Выполнение действия
		switch ($action) {
			// Установка свойств базового типа
			case 'get' :
				return $this->$property;

			case 'register' :
				if (is_array($arguments[0])) {
					$this->$property = array_merge($this->$property, $arguments[0]);
				} else {
					$this->$property[] = $arguments[0];
				}
				break;

			case 'set' :
				$this->$property = $arguments[0];
				break;
		}


		return $this;
	}
}