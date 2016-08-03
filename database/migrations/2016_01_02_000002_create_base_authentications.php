<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Chunker\Base\Libs\Columns;

class CreateBaseAuthentications extends Migration
{
	protected $table = 'base_authentications';


	public function up() {
		Schema::create($this->table, function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Аутентификации пользователей';

			// Ключ
			Columns::id($table);

			// Ключ пользователя
			$table
				->integer('user_id')
				->unsigned()
				->index()
				->comment('Ключ пользователя');

			// Идентификатор браузера
			$table
				->string('user_agent')
				->comment('Идентификатор браузера');

			// IP-адрес
			$table
				->bigInteger('ip_address')
				->unsigned()
				->comment('IP-адрес');

			// Флаг проваленной авторизации
			$table
				->boolean('is_failed')
				->default(false)
				->index()
				->comment('Флаг проваленной авторизации');

			// Время аутентификации
			$table
				->timestamp('logged_in_at')
				->index()
				->comment('Время аутентификации');

			// Время последнего запроса
			$table
				->timestamp('last_request_at')
				->nullable()
				->index()
				->comment('Время последнего запроса');

		});
	}


	public function down() {
		Schema::drop($this->table);
	}
}
