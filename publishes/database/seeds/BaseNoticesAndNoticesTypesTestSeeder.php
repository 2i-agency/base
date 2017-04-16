<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Notice;
use Chunker\Base\Models\NoticesType;
use Chunker\Base\Models\User;
use Chunker\Base\Models\Role;

class BaseNoticesAndNoticesTypesTestSeeder extends Seeder
{
	/**
	 * Получает случайный список ключей модели
	 *
	 * @param string $class
	 *
	 * @return mixed
	 */
	protected function getRandomIds($class) {
		return ( new $class )
			->orderByRaw("RAND()")
			->take(rand(1, 5))
			->pluck('id')
			->toArray();
	}


	public function run() {

		// Чистим таблицы
		Notice::truncate();
		NoticesType::truncate();

		// Очищаем связующие таблицы
		\DB::table('base_notices_type_role_user')->truncate();
		\DB::table('base_notices_users')->truncate();

		$count = rand(2, 8);
		factory(NoticesType::class, $count)
			->create()
			->each(function($noticeType) {

				if (rand(0, 1)) {
					$users = $this->getRandomIds(User::class);
					$noticeType
						->users()
						->sync($users);
				}

				if (rand(0, 1)) {
					$roles = $this->getRandomIds(Role::class);
					$noticeType
						->roles()
						->sync($roles);
				}

			});

		$count = rand(5, 15);
		factory(Notice::class, $count)
			->create()
			->each(function($notice) {

				if (rand(0, 1)) {
					$notice->update([
						'type_id' => NoticesType::orderByRaw('RAND()')->first()
					]);
				}

			});
	}
}