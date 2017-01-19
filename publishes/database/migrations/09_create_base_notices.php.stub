<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Chunker\Base\Libs\Columns;

/**
 * Миграция для таблицы уведомлений
 */
class CreateBaseNotices extends Migration
{
	protected $table = 'base_notices';


	public function up(){
		Schema::create($this->table, function(Blueprint $table){

			$table->engine = 'MyISAM';
			$table->comment = 'Уведомления';

			/** Ключ */
			Columns::id($table);

			/** Ключ типа */
			$table
				->integer('type_id')
				->unsigned()
				->nullable()
				->index()
				->comment('Ключ типа');

			/** Содержимое */
			$table
				->text('content')
				->comment('Содержимое');

			/** Прочитано */
			$table
				->boolean('is_read')
				->index()
				->comment('Прочитано');

			/** Время создания и обновления */
			$table->timestamps();

		});
	}


	public function down(){
		Schema::drop($this->table);
	}
}