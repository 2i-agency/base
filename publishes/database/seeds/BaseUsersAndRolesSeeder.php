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
	public function run() {
		$role = $this->seedengRole();
		$this->seedingUsers($role);
	}


	protected function seedengRole():Role {
		$abilities = array_keys(app('Packages')->getAbilities());

		/** @var Role $role */
		$role = Role::firstOrCreate([ 'name' => 'Администратор' ]);

		$role->abilities()->detach();
		foreach ($abilities as $ability) {
			if (!$role->hasAccess($ability)) {
				$role->abilities()->attach($ability);
				$role->save();
			}
		}

		return $role;
	}


	protected function seedingUsers(Role $role) {
		if(app()->environment() === 'production' && User::count() == 0) {
			$user = $this->createUser('2i', mb_substr(hash('md5', microtime()), 0, 12), 'Разработчик', 'mail@studio2i.ru', false);
			$user->roles()->attach($role);
			$user = $this->createUser('admin', mb_substr(hash('md5', microtime()), 0, 12), 'Администратор', 'mail@' . host());
			$user->roles()->attach($role);
		} elseif(app()->environment() !== 'production') {
			/** @var User $user */
			$user = User::where('login', 'admin')->first();

			if (!$user) {
				$user = $this->createUser('admin', '000000', 'Администратор', 'mail@' . host());
			}

			$user->roles()->detach();
			$user->roles()->attach($role);
		}
	}


	protected function createUser(string $login, string $password, string $name, string $email, bool $isSubscribed = true):User {
		$user = User::create([
			'login'         => $login,
			'password'      => $password,
			'email'         => $email,
			'name'          => $name,
			'is_subscribed' => $isSubscribed,
			'is_admin'      => true
		]);
		echo sprintf('Пользователь: %s	Пароль: %s%s', $login, $password, PHP_EOL);

		return $user;
	}
}