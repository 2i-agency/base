<?php

namespace Chunker\Base\Models\Observers;

use Illuminate\Database\Eloquent\Model;
use Storage;

class LanguageObserver
{
	public function creating(Model $model) {
		$model->locale = $model->getAttribute('locale') ?: $model->getAttribute('name');
	}


	public function updating(Model $model) {
		// Переименование папки с переводом в случае смены локали
		$old_locale = $model->getOriginal('locale');
		$new_locale = $model->getAttribute('locale');
		$disk = Storage::createLocalDriver(['root' => base_path('resources/lang/vendor/chunker')]);

		if ($old_locale != $new_locale && $disk->exists($old_locale)) {
			$disk->rename($old_locale, $new_locale);
		}
	}
}