<?php

namespace Chunker\Base\Models\Observers;

use Illuminate\Database\Eloquent\Model;

class PictureObserver
{
	public function deleting(Model $model)
	{
		foreach($model->getPicturesFields() as $field)
		{
			$model->deletePicture($field);
		}
	}
}