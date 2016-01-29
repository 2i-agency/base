<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAuthorizations extends Migration
{
	public function up()
	{
		Schema::create('authorizations', function (Blueprint $table) {

			$table->engine = 'MyISAM';

			// Ключ
			$table->increments('id');

			// Ключ пользователя
			$table
				->integer('user_id')
				->unsigned()
				->index();

			// Идентификатор браузера
			$table->string('user_agent');

			// IP-адрес
			$table
				->bigInteger('ip_address')
				->unsigned();

			// Флаг проваленной авторизации
			$table
				->boolean('is_failed')
				->default(false)
				->index();

			// Время авторизации
			$table
				->timestamp('logged_in_at')
				->index();

			// Время последнего запроса на сервер в сеансе
			$table
				->timestamp('last_request_at')
				->nullable()
				->index();

		});
	}


	public function down()
	{
		Schema::drop('authorizations');
	}
}
