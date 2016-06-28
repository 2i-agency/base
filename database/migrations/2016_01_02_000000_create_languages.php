<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Kalnoy\Nestedset\NestedSet;
use Chunker\Base\Libs\Columns;

class CreateLanguages extends Migration
{
	protected $table = 'languages';


	public function up() {
		Schema::create($this->table, function (Blueprint $table) {

			$table->engine = 'MyISAM';
			$table->comment = 'Языки';

			// Ключ
			$table
				->increments('id')
				->comment('Ключ');

			// Название
			Columns::name($table);

			// Локаль
			$table
				->string('locale')
				->unique()
				->comment('Локаль');

			// Поля для дерева
			NestedSet::columns($table);

			// Флаг публикации
			$table
				->boolean('is_published')
				->index()
				->comment('Флаг публикации');

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
