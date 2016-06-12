<?php

namespace Chunker\Base\Models\Observers;

use Illuminate\Database\Eloquent\Model;
use Storage;

class LanguageObserver
{
	public function creating(Model $model) {
		$model->route_key = $model->getAttribute('route_key') ?: $model->getAttribute('name');
	}


	public function updating(Model $model) {
		// Переименование папки с переводом в случае смены ключа маршрута
		$old_directory = $model->getOriginal('route_key');
		$new_directory = $model->getAttribute('route_key');
		$disk = Storage::createLocalDriver(['root' => base_path('resources/lang/vendor/chunker')]);

		if ($old_directory != $new_directory && $disk->exists($old_directory)) {
			$disk->rename($old_directory, $new_directory);
		}
	}
}