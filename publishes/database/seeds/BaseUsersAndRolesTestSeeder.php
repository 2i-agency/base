<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Ability;
use Chunker\Base\Models\User;
use Chunker\Base\Models\Role;

class BaseUsersAndRolesTestSeeder extends Seeder
{
	protected $abilities;

	public function __construct() {
		$abilities = app('Packages')->getAbilities();

		foreach ($abilities as $ability => $name) {
			$suffixes = explode('.', $ability);
			$prefix = array_first($suffixes);
			$postfix = array_last($suffixes);

			$this->abilities[$prefix][] = $postfix;
		}
	}

	protected function getRandomAbilities() {
		$result = [];
		$count = rand(1, count($this->abilities));
		$abilities = array_rand($this->abilities, $count);

		if (!is_array($abilities)) {
			$abilities = [$abilities];
		}

		foreach ($abilities as $ability) {
			$action = array_rand($this->abilities[$ability]);
			$action = $this->abilities[$ability][$action];

			$result[] = $ability . '.' . $action;
		}

		return $result;
	}

	public function run() {
		// Чистим таблицы
		Ability::truncate();
		Role::truncate();
		User::truncate();

		// Очищаем связующие таблицы
		\DB::table('base_abilities_roles_users')->truncate();
		\DB::table('base_agents')->truncate();
		\DB::table('base_roles_users')->truncate();

		// Сеем абилки
		$this->call(BaseAbilitiesSeeder::class);

		// Сеем административного пользователя и роль
		$this->call(BaseUsersAndRolesSeeder::class);

		$count = rand(2, 8);
		factory(Role::class, $count)
			->create()
			->each(function($role) {
				if (rand(0, 1)) {
					$abilities = $this->getRandomAbilities();
					$role->abilities()->sync($abilities);
				}
			});

		$count = rand(5, 20);
		factory(User::class, $count)
			->create()
			->each(function($user) {

				if (rand(0, 1)) {
					$roles = Role
						::where('id', '<>', 1)
						->orderByRaw("RAND()")
						->take(rand(1, 5))
						->pluck('id')
						->toArray();

					$user->roles()->sync($roles);
				}

				if (rand(0, 1)) {
					$abilities = $this->getRandomAbilities();
					$user->abilities()->sync($abilities);
				}
			});
	}
}