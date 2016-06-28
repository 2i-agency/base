<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotices extends Migration
{
	public function up()
	{
		Schema::create('notices', function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Уведомления';

			// Ключ
			$table->increments('id');

			// Содержимое
			$table->text('content');

			// Прочитано
			$table
				->boolean('is_read')
				->index();

			// Время создания и обновления
			$table->timestamps();

		});
	}


	public function down()
	{
		Schema::drop('notices');
	}
}
