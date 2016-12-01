<?php

namespace Chunker\Base\Models;

use Chunker\Base\Models\Traits\MediaConversions;
use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

class Language extends Model implements HasMediaConversions
{
	use BelongsToEditors, NodeTrait, HasMediaTrait, MediaConversions;

	protected $table = 'base_languages';

	// Переменная для указания списка конверсий
	protected $conversions_config = 'chunker.localization.flag.conversions';

	protected $fillable = [
		'name',
		'locale',
		'is_published'
	];

	protected $casts = [
		'is_published' => 'boolean'
	];


	/*
	 * Настройка ключа для привязки к маршруту
	 */
	public function getRouteKeyName() {
		return 'locale';
	}


	/*
	 * Подготовка локали
	 */
	public function setLocaleAttribute($locale) {
		$this->attributes['locale'] = str_slug(mb_strlen(trim($locale)) ? $locale : $this->attributes['name']);
	}


	public static function boot() {

		static::saved(function ($instance) {

			$request = request();

			// Разрешено ли использовать флаг
			if (flag_is_active()) {

				$flags = $instance->getMedia();

				// Есть ли файлы для загрузки
				if (count($request->allFiles()) ) {

					$flag = $request->allFiles()['flag'];

					if ($flag->isValid()) {
						$original_extension = $flag->getClientOriginalExtension();

						// Если в базе уже есть флаг, то удалить его
						if($instance->hasMedia()){
							foreach ($flags as $flag) {
								$flag->delete();
							}
						}

						// Добавить новый флаг
						$instance->copyMedia($flag . $original_extension)
							->setFileName('original.' . $original_extension)
							->toCollection('language.flag');
					}

				}
				elseif($instance->hasMedia() && $request->delete_flag){

					foreach ($flags as $flag) {
						$flag->delete();
					}
				}

			}


		});

		parent::boot();

	}
}