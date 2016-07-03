<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Chunker\Base\Libs\Columns;

class CreateAbilities extends Migration
{
	protected $table = 'abilities';


	public function up() {
		Schema::create($this->table, function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Возможности пользователей';

			// Ключ
			$table
				->string('id')
				->primary()
				->comment('Ключ');

			// Название
			Columns::name($table);

			// Время создания и обновления
			$table->timestamps();

		});
	}


	public function down() {
		Schema::drop($this->table);
	}
}
