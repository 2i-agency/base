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

	// Возможности
	protected $abilities = [];

	// Представления для редактирования возможностей
	protected $abilitiesViews = [];


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
	 * Зарегистрировать возможность
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
	 * Получить возможности
	 */
	public function getAbilities() {
		return $this->abilities;
	}


	/*
	 * Зарегистрировать возможность
	 */
	public function registerAbilitiesViews($abilitiesViews) {
		if (is_array($abilitiesViews)) {
			$this->abilitiesViews = array_merge($this->abilitiesViews, $abilitiesViews);
		} else {
			$this->abilitiesViews[] = (string)($abilitiesViews);
		}

		return $this;
	}


	/*
	 * Получить представления возможностей
	 */
	public function getAbilitiesViews() {
		return $this->abilitiesViews;
	}
}