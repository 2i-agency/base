<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration
{
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {

			$table->engine = 'MyISAM';

			// Ключ
			$table->increments('id');

			// Логин
			$table
				->string('login')
				->unique();

			// Хеш пароля
			$table->string('password', 60);

			// Токен для запоминания
			$table->rememberToken();

			// Электронный адрес
			$table
				->string('email')
				->index();

			// Имя
			$table
				->string('name')
				->nullable();

			// Ключ создателя
			$table
				->integer('creator_id')
				->unsigned()
				->nullable()
				->index();

			// Ключ обновителя
			$table
				->integer('updater_id')
				->unsigned()
				->nullable()
				->index();

			// Время создания и обновления
			$table->timestamps();

			// Время удаления
			$table->softDeletes();

		});
	}


	public function down()
	{
		Schema::drop('users');
	}
}
