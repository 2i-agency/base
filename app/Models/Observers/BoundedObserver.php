<?php

namespace Chunker\Base\Models\Observers;

use Illuminate\Database\Eloquent\Model;

class BoundedObserver
{
	public function creating(Model $model) {
		$model->placeToEnd();
	}


	public function deleting(Model $model) {
		$model
			->deleteChildren()
			->pullSiblings();
	}
}