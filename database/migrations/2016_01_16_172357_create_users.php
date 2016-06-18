<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Chunker\Base\Libs\Columns;

class CreateUsers extends Migration
{
	public $table = 'users';


	public function up() {
		Schema::create($this->table, function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Пользователи';

			// Ключ
			$table
				->increments('id')
				->comment('Ключ');

			// Логин
			$table
				->string('login')
				->unique()
				->comment('Логин');

			// Хеш пароля
			$table
				->string('password', 60)
				->comment('Пароль');

			// Токен для запоминания
			$table
				->rememberToken()
				->comment('Токен для запоминания');

			// Электронный адрес
			$table
				->string('email')
				->index()
				->comment('Электронный адрес');

			// Имя
			$table
				->string('name')
				->nullable()
				->comment('Имя пользователя');

			// Ключи создателя и обновителя
			Columns::editorsIds($table);

			// Время создания и обновления
			$table->timestamps();

			// Время удаления
			$table->softDeletes();

		});
	}


	public function down() {
		Schema::drop($this->table);
	}
}
