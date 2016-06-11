<?php

namespace Chunker\Base\Libs;

use Illuminate\Database\Schema\Blueprint;

class Columns
{
	/*
	 * Ключ создателя
	 */
	public static function creatorId(Blueprint $table) {
		$table
			->integer('creator_id')
			->unsigned()
			->nullable()
			->index()
			->comment('Ключ создателя');
	}


	/*
	 * Ключ обновителя
	 */
	public static function updaterId(Blueprint $table) {
		$table
			->integer('updater_id')
			->unsigned()
			->nullable()
			->index()
			->comment('Ключ обновителя');
	}


	/*
	 * Ключи редакторов
	 */
	public static function editorsIds(Blueprint $table) {
		static::creatorId($table);
		static::updaterId($table);
	}


	/*
	 * Название
	 */
	public static function name(Blueprint $table) {
		$table
			->string('name')
			->index()
			->comment('Название');
	}


	/*
	 * Заголовок
	 */
	public static function metaTitle(Blueprint $table) {
		$table
			->string('meta_title')
			->nullable()
			->comment('Заголовок');
	}


	/*
	 * Ключевые слова
	 */
	public static function metaKeywords(Blueprint $table) {
		$table
			->string('meta_keywords')
			->nullable()
			->comment('Ключевые слова');
	}


	/*
	 * Название
	 */
	public static function metaDescription(Blueprint $table) {
		$table
			->string('meta_description')
			->nullable()
			->comment('Описание');
	}


	/*
	 * Основные мета-теги
	 */
	public static function baseMeta(Blueprint $table) {
		static::metaTitle($table);
		static::metaKeywords($table);
		static::metaDescription($table);
	}
}