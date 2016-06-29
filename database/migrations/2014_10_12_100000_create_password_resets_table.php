<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePasswordResetsTable extends Migration
{
	public function up() {
		Schema::create('password_resets', function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Запросы на восстановление паролей';

			// Электронный адрес
			$table->string('email')->index();

			// Токен
			$table->string('token')->index();

			// Время создания
			$table->timestamp('created_at');

		});
	}


	public function down() {
		Schema::drop('password_resets');
	}
}