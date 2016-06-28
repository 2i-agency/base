<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\User;

class UsersSeeder extends Seeder
{
	public function run() {
		// Добавление администратора
		User::create([
			'login' => 'admin',
			'password' => '000000',
			'email' => 'mail@' . env('APP_URL'),
			'name' => 'Администратор',
			'is_subscribed' => true
		]);
	}
}