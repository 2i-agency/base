<?php

$factory->defineAs(\Chunker\Base\Models\Setting::class, 'mail_address', function(Faker\Generator $faker) {
	return [
		'id'           => 'mail_address',
		'title'        => 'Электронный адрес',
		'control_type' => 'email',
		'value'        => $faker->email,
		'hint'         => 'Используется сайтом для отправки системных уведомлений'
	];
});

$factory->defineAs(\Chunker\Base\Models\Setting::class, 'mail_author', function(Faker\Generator $faker) {
	return [
		'id'           => 'mail_author',
		'title'        => 'Имя отправителя',
		'control_type' => 'text',
		'value'        => 'Система оповещений ' . $faker->company
	];
});

$factory->defineAs(\Chunker\Base\Models\Setting::class, 'mail_host', function(Faker\Generator $faker) {
	return [
		'id'           => 'mail_host',
		'title'        => 'Адрес сервера исходящей почты',
		'control_type' => 'text',
		'value'        => $faker->domainName
	];
});

$factory->defineAs(\Chunker\Base\Models\Setting::class, 'mail_port', function(Faker\Generator $faker) {
	return [
		'id'           => 'mail_port',
		'title'        => 'Порт',
		'control_type' => 'number',
		'value'        => $faker->randomNumber(4)
	];
});

$factory->defineAs(\Chunker\Base\Models\Setting::class, 'mail_username', function(Faker\Generator $faker) {
	return [
		'id'           => 'mail_username',
		'title'        => 'Пользователь',
		'control_type' => 'text',
		'value'        => $faker->userName
	];
});

$factory->defineAs(\Chunker\Base\Models\Setting::class, 'mail_password', function(Faker\Generator $faker) {
	return [
		'id'           => 'mail_password',
		'title'        => 'Пароль',
		'control_type' => 'password',
		'value'        => $faker->password()
	];
});

$factory->defineAs(\Chunker\Base\Models\Setting::class, 'mail_encryption', function(Faker\Generator $faker) {
	return [
		'id'           => 'mail_encryption',
		'title'        => 'Шифрование',
		'control_type' => 'text',
	];
});
