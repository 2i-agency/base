<?php

namespace Chunker\Base\Models\Traits\BelongsTo;

use Chunker\Base\Models\Language;
use Session;

/**
 * Trait BelongsToLanguage - Трейт для подключения связи с моделью Language
 *
 * @package Chunker\Base\Models\Traits\BelongsTo
 */
trait BelongsToLanguage
{
	/**
	 * Язык
	 *
	 * @return mixed - звязь с моделью языка
	 */
	public function language() {
		return $this->belongsTo(Language::class);
	}


	/**
	 * Ассоциация с текущей локалью
	 *
	 * @return $this
	 */
	public function associateWithCurrentLocale() {
		$language = Language::where('locale', Session::get('admin.locale'))->first();

		$this
			->language()
			->associate($language);


		return $this;
	}
}