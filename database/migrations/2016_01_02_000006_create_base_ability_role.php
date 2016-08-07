<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaseAbilityRole extends Migration
{
	protected $table = 'base_ability_role';


	public function up() {
		Schema::create($this->table, function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Связи между возможностями и ролями пользователей';

			// Ключ возможности
			$table
				->string('ability_id')
				->index()
				->comment('Ключ возможности');

			// Ключ роли
			$table
				->integer('role_id')
				->unsigned()
				->index()
				->comment('Ключ роли');

			// Опции
			$table
				->json('options')
				->nullable()
				->comment('Опции');

		});
	}


	public function down() {
		Schema::drop($this->table);
	}
}