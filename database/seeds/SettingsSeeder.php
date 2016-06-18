<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Setting;

class SettingsSeeder extends Seeder
{
	public function run() {
		// Подготовка данных
		$settings = [

			// Электронная почта
			[
				'id' => 'mail_address',
				'title' => 'Электронный адрес',
				'control_type' => 'email',
				'value' => 'mail@' . host(),
				'hint' => 'Используется сайтом для отправки системных уведомлений'
			],
			[
				'id' => 'mail_author',
				'title' => 'Имя отправителя',
				'control_type' => 'text',
				'value' => 'Система оповещений ' . host()
			],
			[
				'id' => 'mail_host',
				'title' => 'Адрес сервера исходящей почты',
				'control_type' => 'text'
			],
			[
				'id' => 'mail_port',
				'title' => 'Порт',
				'control_type' => 'number'
			],
			[
				'id' => 'mail_username',
				'title' => 'Пользователь',
				'control_type' => 'text'
			],
			[
				'id' => 'mail_password',
				'title' => 'Пароль',
				'control_type' => 'password'
			],
			[
				'id' => 'mail_encryption',
				'title' => 'Шифрование',
				'control_type' => 'text'
			]

		];


		// Очистка таблицы
		Setting::truncate();


		// Добавление данных
		foreach ($settings as $setting)
		{
			Setting::create($setting);
		}
	}
}