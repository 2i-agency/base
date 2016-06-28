<?php

namespace Chunker\Base\Libs;

use Illuminate\Database\Schema\Blueprint;

class Columns
{
	/*
	 * Первичный ключ
	 */
	public static function id(Blueprint $table) {
		$table
			->increments('id')
			->comment('Ключ');
	}


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
	 * Контент
	 */
	public static function content(Blueprint $table) {
		$table
			->longText('content')
			->nullable()
			->comment('Контент');
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
	 * Описание
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
		static::metaDescription($table);
	}


	/*
	 * Время публикации
	 */
	public static function publishedAt(Blueprint $table) {
		$table
			->timestamp('published_at')
			->nullable()
			->index()
			->comment('Время публикации');
	}
}