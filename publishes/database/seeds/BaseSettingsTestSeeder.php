<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Setting;

/**
 * Посев настроек
 */
class BaseSettingsTestSeeder extends Seeder
{
	public function run() {
		Setting::truncate();

		/** Подготовка данных */
		$settings = [
			'mail_address',
			'mail_author',
			'mail_host',
			'mail_port',
			'mail_username',
			'mail_password',
			'mail_encryption',
		];

		/** Добавление данных */
		foreach ($settings as $setting) {
			factory(Setting::class, $setting)->create();
		}
	}
}