<?php

use Illuminate\Database\Seeder;
use Chunker\Base\Models\User;

class UsersSeeder extends Seeder
{
	public function run()
	{
		// Adding admin user
		User::create([
			'login' => 'admin',
			'password' => '000000',
			'email' => 'mail@mail.net',
			'name' => 'Администратор'
		]);
	}
}