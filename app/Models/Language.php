<?php

namespace Chunker\Base\Models;

use Illuminate\Database\Eloquent\Model;
use Kalnoy\Nestedset\NodeTrait;
use Chunker\Base\Models\Traits\BelongsTo\BelongsToEditors;

class Language extends Model
{
	use BelongsToEditors, NodeTrait;

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