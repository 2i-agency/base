<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\MediaConversions;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * Модель языка
 *
 * @package Chunker\Base\Commands
 */
class Language extends Model implements HasMediaConversions
{
	use BelongsToEditors, NodeTrait, HasMediaTrait, MediaConversions;

	/** @var string название таблицы */
	protected $table = 'base_languages';

	/** @var string Переменная для указания списка конверсий */
	protected $conversions_config = 'chunker.localization.icon.conversions';

	/** @var array поля для массового присвоения атрибутов */
	protected $fillable = [
		'name',
		'locale',
		'is_published'
	];

	/** @var array поля для мутаторов */
	protected $casts = [
		'is_published' => 'boolean'
	];


	/**
	 * Настройка ключа для привязки к маршруту
	 *
	 * @return string
	 */
	public function getRouteKeyName(){
		return 'locale';
	}


	/**
	 * Подготовка локали
	 *
	 * @param string $locale
	 */
	public function setLocaleAttribute($locale){
		$this->attributes[ 'locale' ] = str_slug(mb_strlen(trim($locale)) ? $locale : $this->attributes[ 'name' ]);
	}

}