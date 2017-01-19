<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

/**
 * Миграция добавляющая в таблицу media поля для позиционирования объектов
 */
class AddTreeToMedia extends Migration
{
	protected $table = 'media';


	public function up(){
		Schema::table($this->table, function(Blueprint $table){

			/** Поля для дерева */
			NestedSet::columns($table);

		});
	}


	public function down(){
		Schema::table($this->table, function(Blueprint $table){
			NestedSet::dropColumns($table);
		});

	}
}
