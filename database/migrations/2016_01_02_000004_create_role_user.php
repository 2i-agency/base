<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoleUser extends Migration
{
	protected $table = 'role_user';


	public function up() {
		Schema::create($this->table, function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Связи между ролями и пользователями';

			// Ключ роли
			$table
				->integer('role_id')
				->unsigned()
				->index()
				->comment('Ключ роли');

			// Ключ пользователя
			$table
				->integer('user_id')
				->unsigned()
				->index()
				->comment('Ключ пользователя');

		});
	}


	public function down() {
		Schema::drop($this->table);
	}
}
