<?php

namespace Chunker\Base\Packages;

class Manager
{
	// Зарегестрированные пакеты
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
	 * Список зарегистрированных пакетов
	 */
	public function getPackages() {
		return $this->packages;
	}
}