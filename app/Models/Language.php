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
}