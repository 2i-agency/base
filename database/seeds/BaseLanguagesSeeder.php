<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Language;

class BaseLanguagesSeeder extends Seeder
{
	public function run() {
		$name = 'RU';

		if (!Language::where('name', $name)->count()) {
			// Добавление русского языка
			Language::create([
				'name' => $name,
				'is_published' => true
			]);
		}
	}
}