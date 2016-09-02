<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class AddTreeToMedia extends Migration
{
	protected $table = 'media';


	/*
	 * Добавление полей для сортировки
	 */
	public function up() {
		Schema::table($this->table, function (Blueprint $table) {

			// Поля для дерева
			NestedSet::columns($table);

		});
	}


	/*
	 * Удаление полей для сортировки
	 */
	public function down() {
		Schema::table($this->table, function (Blueprint $table) {

			// Поля для дерева
			NestedSet::dropColumns($table);

		});

	}
}
