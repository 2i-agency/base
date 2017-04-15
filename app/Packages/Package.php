<?php

namespace Chunker\Base\Packages;

/**
 * Описание пакета Chunker
 *
 * @package Chunker\Base\Packages
 */
class Package
{
	/** @var string Название пакета */
	protected $name;

	/** @var array Возможности пакета */
	protected $abilities = [];

	/** @var array Представления для редактирования возможностей пакета */
	protected $abilitiesViews = [];

	/** @var array Посевщики пакета */
	protected $seeders = [];

	/** @var array Тестовые посевщики пакета */
	protected $testSeeders = [];

	/** @var array Пункты меню */
	protected $menuItems = [];

	/** @var array Сущности */
	protected $activityElements = [];

	/** @var array Элементы баннеров */
	protected $bannersElements = [];


	/**
	 * Доступ к свойствам,
	 * установка свойств базового типа,
	 * регистрация данных в свойствах-массивах.
	 *
	 * @param string $method
	 * @param array  $arguments
	 *
	 * @return $this|null
	 */
	public function __call($method, $arguments){
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
				if (is_array($arguments[ 0 ])) {
					$this->$property = array_merge($this->$property, $arguments[ 0 ]);
				} else {
					$this->$property[] = $arguments[ 0 ];
				}
				break;

			case 'set' :
				$this->$property = $arguments[ 0 ];
				break;
		}

		return $this;
	}
}