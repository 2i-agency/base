<?php

namespace Chunker\Base\Models\Observers;

use Illuminate\Database\Eloquent\Model;
use Storage;

class LanguageObserver
{
	public function created(Model $model)
	{
		$disk = Storage::createLocalDriver(['root' => base_path('/resources/lang')]);
	}
}