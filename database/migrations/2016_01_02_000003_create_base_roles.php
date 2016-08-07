<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Chunker\Base\Libs\Columns;

class CreateBaseRoles extends Migration
{
	protected $table = 'base_roles';


	public function up() {
		Schema::create($this->table, function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Роли пользователей';

			// Ключ
			Columns::id($table);

			// Название
			Columns::name($table);

			// Ключи создателя и обновителя
			Columns::editorsIds($table);

			// Время создания и обновления
			$table->timestamps();

		});
	}


	public function down() {
		Schema::drop($this->table);
	}
}