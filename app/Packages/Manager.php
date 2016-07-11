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
	 * Зарегистрированные пакеты
	 */
	public function getPackages($package = NULL) {
		return is_null($package) ? $this->packages : $this->packages[$package];
	}


	/*
	 * Возможности их пакетов
	 */
	public function getAbilities($packageName = NULL) {
		if (!is_null($packageName) && !is_array($packageName)) $packageName = [$packageName];

		$abilities = [];

		foreach ($this->getPackages() as $package) {
			if (is_null($packageName) || in_array($package->getName(), $packageName))
			{
				$abilities = array_merge($package->getAbilities());
			}
		}

		return $abilities;
	}
}