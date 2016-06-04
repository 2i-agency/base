<?php

namespace Chunker\Base\Helpers;

use Route;

class AdminMenu
{
	protected $structure;
	protected $currentRoute;


	public function __construct() {
		$this->structure = config('chunker.admin.menu');
		$this->currentRoute = Route::currentRouteName();
	}


	/*
	 * Получение ссылки на контрольную панель админцентра
	 */
	public function dashboard() {
		return route('admin.dashboard');
	}


	/*
	 * Визуализация разметки навигации
	 */
	public function render() {
		$markup = '';

		foreach ($this->structure as $parent) {
			if (isset($parent['children'])) {
				$markup .= $this->renderSection($parent);
			} else {
				$markup .= $this->renderElement($parent);
			}
		}

		$markup = '<ul class="nav navbar-nav">' . $markup . '</ul>';


		return $markup;
	}


	/*
	 * Проверка активности элемента
	 */
	protected function isElementActive($route) {
		return starts_with($this->currentRoute, $route . '.') || $this->currentRoute == $route;
	}


	/*
	 * Визуализация разметки отдельного элемента
	 */
	protected function renderElement($data) {
		return '
		<li' . ($this->isElementActive($data['route']) ? ' class="active"' : NULL) . '>
			<a href="' . route($data['route']) . '">
				' . $this->renderIcon($data) . '
				' . $data['name'] . '
			</a>
		</li>';
	}


	/*
	 * Визуализация разметки выпадающего списка раздела
	 */
	protected function renderSection($data) {
		$markup = '';
		$active = false;

		foreach ($data['children'] as $child) {
			$active = $active || $this->isElementActive($child['route']);
			$markup .= $this->renderElement($child);
		}

		$markup = '
		<li class="dropdown' . ($active ? ' active' : NULL) . '">
			<a
				href="#"
				class="dropdown-toggle"
				data-toggle="dropdown">
				' . $this->renderIcon($data) . '
				' . $data['name'] . '
				<span class="caret"></span>
			</a>
			<ul class="dropdown-menu">' . $markup . '</ul>
		</li>';


		return $markup;
	}


	/*
	 * Визуализация иконки
	 */
	protected function renderIcon($data) {
		if (isset($data['icon'])) {
			return '<span class="fa fa-' . $data['icon'] . '"></span>';
		} else {
			return NULL;
		}
	}
}