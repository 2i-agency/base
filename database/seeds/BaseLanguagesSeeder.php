<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Language;

class BaseLanguagesSeeder extends Seeder
{
	public function run() {
		// Добавление русского языка
		Language::create([
			'name' => 'RU',
			'is_published' => true
		]);
	}
}