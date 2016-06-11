<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;

class CreateLanguages extends Migration
{
	public function up() {
		Schema::create('languages', function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Языки';

			// Ключ
			$table
				->increments('id')
				->comment('Ключ');

			// Название
			$table
				->string('name')
				->comment('Название');

			// Ключ маршрута
			$table
				->string('route_key')
				->unique()
				->comment('Ключ маршрута');

			// Поля для дерева
			NestedSet::columns($table);

			// Флаг публикации
			$table
				->boolean('is_published')
				->index()
				->comment('Флаг публикации');

			// Ключ создателя
			$table
				->integer('creator_id')
				->unsigned()
				->nullable()
				->index()
				->comment('Ключ создателя');

			// Ключ обновителя
			$table
				->integer('updater_id')
				->unsigned()
				->nullable()
				->index()
				->comment('Ключ обновителя');

			// Время создания и обновления
			$table->timestamps();

		});
	}


	public function down() {
		Schema::drop('languages');
	}
}
