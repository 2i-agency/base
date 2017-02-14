<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\MediaConversions;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;
use Storage;

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


	public static function boot(){

		/**
		 * Полю locale присваивается значение поля name если локаль не задана
		 */
		static::creating(function($instance){
			$instance->locale = $instance->getAttribute('locale') ?: $instance->getAttribute('name');
		});

		/**
		 * Переименование папки с переводом в случае смены локали
		 */
		static::updating(function($instance){
			$old_locale = $instance->getOriginal('locale');
			$new_locale = $instance->getAttribute('locale');
			$disk = Storage::createLocalDriver([ 'root' => base_path('resources/lang/vendor/chunker') ]);

			if (( $old_locale != $new_locale ) && $disk->exists($old_locale)) {
				$disk->rename($old_locale, $new_locale);
			}
		});

		parent::boot();
	}

}