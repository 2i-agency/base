<?php

namespace Chunker\Base\Models\Observers;

use Chunker\Base\Models\Language;
use Storage;

class LanguageObserver
{
	public function creating(Language $language) {
		$language->locale = $language->getAttribute('locale') ?: $language->getAttribute('name');
	}


	public function updating(Language $language) {
		// Переименование папки с переводом в случае смены локали
		$old_locale = $language->getOriginal('locale');
		$new_locale = $language->getAttribute('locale');
		$disk = Storage::createLocalDriver(['root' => base_path('resources/lang/vendor/chunker')]);

		if ($old_locale != $new_locale && $disk->exists($old_locale)) {
			$disk->rename($old_locale, $new_locale);
		}
	}
}