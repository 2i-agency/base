<?php

namespace Chunker\Base\Packages;

use Chunker\Base\Models\Ability;

/**
 * Менеджер пакетов chunker
 *
 * @package Chunker\Base\Packages
 */
class Manager
{
	/** @var array Зарегистрированные пакеты */
	protected $packages = [];


	/**
	 * Регистрация пакета
	 *
	 * @param Package $package
	 *
	 * @return $this
	 */
	public function register(Package $package){
		$this->packages[ $package->getName() ] = $package;

		return $this;
	}


	/**
	 * Проверка регистрации пакета
	 *
	 * @param string $packageName имя пакета
	 *
	 * @return bool
	 */
	public function isRegistered($packageName){
		return array_key_exists($packageName, $this->packages);
	}


	/**
	 * Получение массива зарегистрированных пакетов.
	 * Если указан параметр $package, возвращается пакет с таким именем
	 *
	 * @param string $package
	 *
	 * @return array|mixed
	 */
	public function getPackages($package = NULL){
		return is_null($package) ? $this->packages : $this->packages[ $package ];
	}


	/**
	 * Получение массива возможностей пакетов.
	 * Если указан параметр $packageName,
	 * возвращается возможности этого пакета или пакетов.
	 *
	 * @param string|array $packageName
	 *
	 * @return array
	 */
	public function getAbilities($packageName = NULL){
		return $this->collectDataFromPackages('ability', $packageName);
	}


	/**
	 * Получение массива с посевщиками пакетов.
	 * Если указан параметр $packageName,
	 * возвращается посевщики этого пакета или пакетов.
	 *
	 * @param string|array $packageName
	 *
	 * @return array
	 */
	public function getSeeders($packageName = NULL){
		return $this->collectDataFromPackages('seeder', $packageName);
	}


	/**
	 * Получение массива с пунктами меню.
	 * Если указан параметр $packageName,
	 * возвращается пункты этого пакета или пакетов.
	 *
	 * @param string|array $packageName
	 *
	 * @return array
	 */
	public function getMenuItems($packageName = NULL){
		return $this->collectDataFromPackages('menuItems', $packageName);
	}


	/**
	 * Проверка активности пункта меню
	 *
	 * @param string $ability возможность по которой будет проходить поиск пункта меню
	 *
	 * @return bool
	 */
	public function isActiveSection($ability) {

		foreach (config('chunker.admin.structure') as $parent) {

			if (isset($parent[ 'children' ])) {

				foreach ($parent[ 'children' ] as $child) {

					if (is_array($child) || ( $child != '' )) {
						if (is_string($child)) {
							$child = $this->getMenuItems()[ $child ];
						}

						if (
							!isset($child[ 'policy' ])
							|| (
								\Auth::user()->can($child[ 'policy' ])
								&& Ability::detectNamespace($child[ 'policy' ]) == Ability::detectNamespace($ability)
							)
						) {
							return true;
						}
					}

				}

			}

		}

		return false;
	}


	/**
	 * Сбор данных из свойств объектов пакетов с помошью методов-геттеров
	 *
	 * @param string       $property
	 * @param string|array $packageName
	 *
	 * @return array
	 */
	protected function collectDataFromPackages($property, $packageName = NULL){
		// Преобразования названия пакета в массив из одного элемента
		if (!is_null($packageName) && !is_array($packageName)) {
			$packageName = [ $packageName ];
		}

		// Массив данных
		$data = [];

		foreach ($this->getPackages() as $package) {
			if (is_null($packageName) || in_array($package->getName(), $packageName)) {
				$method = camel_case('get_' . str_plural($property));
				$data_from_package = $package->$method();

				if (is_array($data_from_package)) {
					$data = array_merge($data, $data_from_package);
				} else {
					$data[] = $data_from_package;
				}
			}
		}

		return $data;
	}
}