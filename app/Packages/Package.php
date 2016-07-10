<?php

namespace Chunker\Base\Packages;

/*
 * Пакет Chunker
 */
use Illuminate\Foundation\Application;

class Package
{
	// Название пакета
	protected $name;

	// Возможности пользователя
	protected $abilities = [];


	/*
	 * Установить название пакета
	 */
	public function setName($name) {
		$this->name = $name;
		return $this;
	}


	/*
	 * Получить название пакета
	 */
	public function getName() {
		return $this->name;
	}


	/*
	 * Зарегистрировать возможность (массив возможностей)
	 */
	public function registerAbilities($abilities) {
		if (is_array($abilities)) {
			$this->abilities = array_merge($this->abilities, $abilities);
		} else {
			$this->abilities[] = (string)($abilities);
		}

		return $this;
	}


	/*
	 * Получить массив возможностей
	 */
	public function getAbilities() {
		return $this->abilities;
	}
}