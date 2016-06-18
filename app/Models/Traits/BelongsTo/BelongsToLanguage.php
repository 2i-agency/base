<?php

namespace Chunker\Base\Models\Traits\BelongsTo;

use Chunker\Base\Models\Language;
use Session;

trait BelongsToLanguage
{
	/*
	 * Язык
	 */
	public function language() {
		return $this->belongsTo(Language::class);
	}


	/*
	 * Ассоциация с текущей локалью
	 */
	public function associateWithCurrentLocale() {
		$language = Language::where('locale', Session::get('admin.locale'))->first();

		$this
			->language()
			->associate($language);


		return $this;
	}
}