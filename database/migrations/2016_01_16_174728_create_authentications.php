<?php

use Illuminate\Database\Schema\Blueprint;
use zedisdog\LaravelSchemaExtend\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateAuthentications extends Migration
{
	public function up() {
		Schema::create('authentications', function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Аутентификации пользователей';

			// Ключ
			$table
				->increments('id')
				->comment('Ключ');

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
		Schema::drop('authentications');
	}
}
