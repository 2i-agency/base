<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotices extends Migration
{
	protected $table = 'notices';


	public function up() {
		Schema::create($this->table, function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Уведомления';

			// Ключ
			Columns::id($table);

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


	public function down() {
		Schema::drop($this->table);
	}
}
