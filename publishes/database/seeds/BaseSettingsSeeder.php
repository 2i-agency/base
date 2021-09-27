<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\Setting;

/**
 * Посев настроек
 */
class BaseSettingsSeeder extends Seeder
{
	public function run(){
		/** Подготовка данных */
		$settings = [
			/** Электронная почта */
			[
				'id'           => 'mail_address',
				'title'        => 'Электронный адрес',
				'control_type' => 'email',
				'value'        => 'mail@' . host(),
				'hint'         => 'Используется сайтом для отправки системных уведомлений'
			],
			[
				'id'           => 'mail_author',
				'title'        => 'Имя отправителя',
				'control_type' => 'text',
				'value'        => 'Система оповещений ' . host()
			],
			[
				'id'           => 'mail_host',
				'title'        => 'Адрес сервера исходящей почты',
				'control_type' => 'text'
			],
			[
				'id'           => 'mail_port',
				'title'        => 'Порт',
				'control_type' => 'number'
			],
			[
				'id'           => 'mail_username',
				'title'        => 'Пользователь',
				'control_type' => 'text'
			],
			[
				'id'           => 'mail_password',
				'title'        => 'Пароль',
				'control_type' => 'password'
			],
			[
				'id'           => 'mail_encryption',
				'title'        => 'Шифрование',
				'control_type' => 'text'
			],
			/** Название сайта */
			[
				'id'           => 'site_name',
				'title'        => 'Название сайта',
				'control_type' => 'text',
//				'value'        => '',
//				'hint'         => 'Используется сайтом для отправки системных уведомлений'
			],
			[
				'id'           => 'meta_title',
				'title'        => 'Заголовок главной страницы',
				'control_type' => 'text',
				'hint'         => 'Отображается во&nbsp;вкладке браузера как название страницы',
			],
			[
				'id'           => 'meta_keywords',
				'title'        => 'Ключевые слова',
				'control_type' => 'text',
				'hint'         => 'Ключевые слова главной страницы <code>&lt;meta name="keywords"&gt;</code>',
			],
			[
				'id'           => 'meta_description',
				'title'        => 'Описание',
				'control_type' => 'text',
				'hint'         => 'Описание главной страницы <code>&lt;meta name="description"&gt;</code>'
			],

		];

		/** Добавление данных */
		foreach ($settings as $setting) {
			if (!Setting::find($setting[ 'id' ])) {
				Setting::create($setting);
			}
		}
	}
}