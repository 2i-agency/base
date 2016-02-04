<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguages extends Migration
{
	public function up()
	{
		Schema::create('languages', function (Blueprint $table) {

			$table->engine = 'MyISAM';

			// Ключ
			$table->increments('id');

			// Название
			$table->string('name');

			// Псевдоним
			$table
				->string('alias')
				->unique();

			// Позиция
			$table
				->tinyInteger('position')
				->unsigned()
				->index();

			// Флаг публикации
			$table
				->boolean('is_published')
				->index();

			// Ключ создателя
			$table
				->integer('creator_id')
				->unsigned()
				->nullable()
				->index();

			// Ключ обновителя
			$table
				->integer('updater_id')
				->unsigned()
				->nullable()
				->index();

			// Время создания и обновления
			$table->timestamps();

		});
	}


	public function down()
	{
		Schema::drop('languages');
	}
}
