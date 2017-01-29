<?php

namespace Chunker\Base\Libs;

use Illuminate\Database\Schema\Blueprint;

/**
 * Набор часто используемых полей для миграций
 *
 * @package Chunker\Base\Libs
 */
class Columns
{
	/**
	 * Поле первичного ключа
	 *
	 * @param Blueprint $table
	 */
	public static function id(Blueprint $table){
		$table
			->increments('id')
			->comment('Ключ');
	}


	/**
	 * Поле для ключа языка
	 *
	 * @param Blueprint $table
	 */
	public static function languageId(Blueprint $table){
		$table
			->integer('language_id')
			->unsigned()
			->index()
			->comment('Ключ языка');
	}


	/**
	 * Поле для ключа пользователя, создавшего модель
	 *
	 * @param Blueprint $table
	 */
	public static function creatorId(Blueprint $table){
		$table
			->integer('creator_id')
			->unsigned()
			->nullable()
			->index()
			->comment('Ключ создателя');
	}


	/**
	 * Поле для ключа пользователя, обновившего модель
	 *
	 * @param Blueprint $table
	 */
	public static function updaterId(Blueprint $table){
		$table
			->integer('updater_id')
			->unsigned()
			->nullable()
			->index()
			->comment('Ключ обновителя');
	}


	/**
	 * Поле для ключа пользователя, удалившего модель
	 *
	 * @param Blueprint $table
	 */
	public static function deleterId(Blueprint $table){
		$table
			->integer('deleter_id')
			->unsigned()
			->nullable()
			->index()
			->comment('Ключ удалившего');
	}


	/**
	 * Поля для мягкого удаления
	 *
	 * @param Blueprint $table
	 */
	public static function softDeleteFields(Blueprint $table){
		$table->softDeletes();
		static::deleterId($table);

	}


	/**
	 * Поля для ключей пользователей, создавших и отредактировавших модель
	 *
	 * @param Blueprint $table
	 */
	public static function editorsIds(Blueprint $table){
		static::creatorId($table);
		static::updaterId($table);
	}


	/**
	 * Поле для названия
	 *
	 * @param Blueprint $table
	 */
	public static function name(Blueprint $table){
		$table
			->string('name')
			->index()
			->comment('Название');
	}


	/**
	 * Поле для контента
	 *
	 * @param Blueprint $table
	 */
	public static function content(Blueprint $table){
		$table
			->longText('content')
			->nullable()
			->comment('Контент');
	}


	/**
	 * Поле для комментария
	 *
	 * @param Blueprint $table
	 * @param bool      $isShort тип поля, VARCHAR(255) или TEXT
	 */
	public static function comment(Blueprint $table, $isShort = true){
		with($isShort ? $table->string('comment') : $table->text('comment'))
			->nullable()
			->comment('Комментарий');
	}


	/**
	 * Поле для хранения заголовка (meta_title)
	 *
	 * @param Blueprint $table
	 */
	public static function metaTitle(Blueprint $table){
		$table
			->string('meta_title')
			->nullable()
			->comment('Заголовок');
	}


	/**
	 * Поле для хранения описания (meta_description)
	 *
	 * @param Blueprint $table
	 */
	public static function metaDescription(Blueprint $table){
		$table
			->string('meta_description')
			->nullable()
			->comment('Описание');
	}


	/**
	 * Поле для хранения ключевых слов (meta_keywords)
	 *
	 * @param Blueprint $table
	 */
	public static function metaKeywords(Blueprint $table){
		$table
			->string('meta_keywords')
			->nullable()
			->comment('Ключевые слова');
	}


	/**
	 * Поле для текстовых идентификаторов (слагов)
	 *
	 * @param Blueprint $table
	 */
	public static function slug(Blueprint $table){
		$table
			->string('slug')
			->unique()
			->comment('Слаги');
	}


	/**
	 * Поля основных мета-тегов (meta_title, meta_description, meta_keywords)
	 *
	 * @param Blueprint $table
	 */
	public static function baseMeta(Blueprint $table){
		static::metaTitle($table);
		static::metaKeywords($table);
		static::metaDescription($table);
	}


	/**
	 * Поле для указания времени публикации
	 *
	 * @param Blueprint $table
	 */
	public static function publishedAt(Blueprint $table){
		$table
			->timestamp('published_at')
			->nullable()
			->index()
			->comment('Время публикации');
	}
}