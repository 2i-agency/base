<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Модель возможности
 *
 * @package Chunker\Base\Commands
 */
class Ability extends Model
{
	/** @var string имя таблицы */
	protected $table = 'base_abilities';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'id',
		'name'
	];


	public static function getName($ability = NULL) {
		$postfix = array_last(explode('.', $ability));

		if ($postfix == 'admin') {
			return 'Администрирование';
		}
		if ($postfix == 'edit') {
			return 'Правка';
		}
		if ($postfix == 'view') {
			return 'Просмотр';
		}
		return 'Нет доступа';
	}


	/**
	 * Возвращает массив действий, доступных для возможности
	 *
	 * @param string $ability возможность
	 *
	 * @return array массив возможностей
	 */
	public static function getPostfixes($ability) {
		$abilities = array_keys(app('Packages')->getAbilities());
		$postfixes = [];

		foreach ($abilities as $package_ability) {
			if (self::detectNamespace($package_ability) == self::detectNamespace($ability)) {
				$postfixes[] = array_last(explode('.', $package_ability));
			}
		}

		return $postfixes;
	}


	/**
	 * Возвращает постфикс возможности администрирования
	 *
	 * @param      $ability
	 * @param bool $with_dot указывает необходимость добавить перед постфиксом точку
	 *
	 * @return mixed|string
	 */
	public static function getAdminPostfix($ability, $with_dot = false) {
		$admin_postfix = array_first(self::getPostfixes($ability));
		if ($with_dot) {
			return '.' . $admin_postfix;
		} else {
			return $admin_postfix;
		}
	}


	public static function getAdminAbility($ability) {
		return self::detectNamespace($ability) . self::getAdminPostfix($ability, true);
	}


	/**
	 * Сравнивает приоритет возможностей
	 *
	 * @param string $needle возможность, которую необходимо проверить
	 * @param string $ability возможность, с которой нужно сравнить
	 *
	 * @return bool
	 */
	public static function getPriority($needle, $ability) {
		$needle_action = array_last(explode('.', $needle));
		$ability_action = array_last(explode('.', $ability));
		$actions = self::getPostfixes($ability);

		return array_search($needle_action, $actions) <= array_search($ability_action, $actions);
	}


	/**
	 * Определение пространства имен
	 *
	 * @param string $ability роль
	 *
	 * @return string название роли
	 */
	public static function detectNamespace($ability) {
		if (count(explode('::', $ability)) > 1) {
			$ability = array_last(explode('::', $ability));
			return array_last(explode('.', $ability));
		}
		return array_first(explode('.', $ability));
	}


	/**
	 * Получение пространства имен
	 *
	 * @return string
	 */
	public function getNamespace() {
		return static::detectNamespace($this->id);
	}


	/**
	 * Отношение с моделью Role
	 *
	 * @return mixed связь с моделью Role
	 */
	public function roles() {
		return $this->morphedByMany(Role::class, 'base_abilities_roles_users');
	}


	/**
	 * Отношение с моделью User
	 *
	 * @return mixed связь с моделью User
	 */
	public function user() {
		return $this->morphedByMany(User::class, 'base_abilities_roles_users');
	}
}