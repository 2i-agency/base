<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Chunker\Base\Libs\Columns;

class CreateSettings extends Migration
{
	public function up()
	{
		Schema::create('settings', function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Настройки';

			// Ключ
			$table
				->increments('id')
				->comment('Ключ');

			// Название
			Columns::name($table);

			// Заголовок
			$table
				->string('title')
				->comment('Заголовок');

			// Значение
			$table
				->string('value')
				->nullable()
				->comment('Значение настройки');

			// Ключ обновителя
			Columns::updaterId($table);

			// Время обновления
			$table
				->timestamp('updated_at')
				->index()
				->comment('Время обновления');

		});
	}


	public function down()
	{
		Schema::drop('settings');
	}
}
