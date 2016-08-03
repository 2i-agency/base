<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\User;
use Chunker\Base\Models\Role;

class UsersAndRolesSeeder extends Seeder
{
	public function run() {
		// Все доступные возможности
		$abilities = array_keys(app()['Packages']->getAbilities());

		// Добавление роли администратора
		$role = Role::create([ 'name'  => 'Администратор' ]);
		$role->abilities()->sync($abilities);

		// Добавление администратора
		$user = User::create([
			'login'         => 'admin',
			'password'      => '000000',
			'email'         => 'mail@' . host(),
			'name'          => 'Администратор',
			'is_subscribed' => true
		]);

		// Сохранение связи с ролью
		$user->roles()->save($role);
	}
}