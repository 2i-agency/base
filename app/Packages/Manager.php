<?php

namespace Chunker\Base\Packages;

class Manager
{
	// Зарегистрированные пакеты
	protected $packages = [];


	/*
	 * Регистрация пакета
	 */
	public function register(Package $package) {
		$this->packages[$package->getName()] = $package;
		return $this;
	}


	/*
	 * Проверки регистрации пакета
	 */
	public function isRegistered($packageName) {
		return array_key_exists($packageName, $this->packages);
	}


	/*
	 * Зарегистрированные пакеты
	 */
	public function getPackages($package = NULL) {
		return is_null($package) ? $this->packages : $this->packages[$package];
	}


	/*
	 * Возможности пакетов
	 */
	public function getAbilities($packageName = NULL) {
		return $this->collectDataFromPackages('ability', $packageName);
	}


	/*
	 * Посевщики
	 */
	public function getSeeders($packageName = NULL) {
		return $this->collectDataFromPackages('seeder', $packageName);
	}


	/*
	 * Сбор данных из свойств объектов пакетов с помошью методов-геттеров
	 */
	protected function collectDataFromPackages($property, $packageName = NULL) {
		// Преобразования названия пакета в массив из одного элемента
		if (!is_null($packageName) && !is_array($packageName)) {
			$packageName = [$packageName];
		}


		// Сбор данных
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