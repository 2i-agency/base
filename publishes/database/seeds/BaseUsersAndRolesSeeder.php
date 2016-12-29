<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\User;
use Chunker\Base\Models\Role;

/**
 * Посев пользователя и роли.
 * Привязка к роли всех возможностей
 */
class BaseUsersAndRolesSeeder extends Seeder
{
	public function run(){
		/** Все доступные возможности */
		$abilities = array_keys(app()[ 'Packages' ]->getAbilities());

		/** Добавление роли администратора */
		$role_name = 'Администратор';
		$role = Role::where('name', $role_name)->first();

		if (!$role) {
			$role = Role::create([ 'name' => $role_name ]);
		}

		/** Настройка возможностей администратора */
		$role->abilities()->sync([]);

		foreach ($abilities as $ability) {
			if (!$role->hasAccess($ability)) {
				$role->abilities()->attach($ability);
				$role->save();
			}
		}

		/** Добавление администратора */
		$login = 'admin';
		$user = User::where('login', $login)->first();

		if (!$user) {
			$user = User::create([
				'login'         => $login,
				'password'      => '000000',
				'email'         => 'mail@' . host(),
				'name'          => 'Администратор',
				'is_subscribed' => true
			]);
		}

		/** Сохранение связи с ролью */
		$user->roles()->sync([ $role->id ]);
	}
}