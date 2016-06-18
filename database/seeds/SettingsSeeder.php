<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Setting;

class SettingsSeeder extends Seeder
{
	public function run() {
		$settings = [
			[
				'id' => 'mail_address',
				'title' => 'Электронный адрес',
				'control_type' => 'email',
				'hint' => 'Используется сайтом для отправки системных уведомлений'
			],
			[
				'id' => 'mail_host',
				'title' => 'Адрес почтового сервера',
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
		
		foreach ($settings as $setting)
		{
			Setting::create($setting);
		}
	}
}