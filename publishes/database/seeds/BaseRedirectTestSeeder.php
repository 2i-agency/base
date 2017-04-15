<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Redirect;

/**
 * Посев языков
 */
class BaseRedirectTestSeeder extends Seeder
{
	public function run(){

		// Очищаем таблицу
		Redirect::truncate();

		$count = rand(5, 25);
		factory(Redirect::class, $count)->create();
	}
}