<?php

namespace Chunker\Base\Models;

use Kalnoy\Nestedset\NodeTrait;
use Spatie\MediaLibrary\Media as BaseMedia;

class Media extends BaseMedia
{
	use NodeTrait;

	protected $table = 'media';

	
	/*
	 * Метод необходим для фильтрации элементов 
	 */
	protected function getScopeAttributes()
	{
		return [ 'model_id', 'model_type', 'collection_name' ];
	}
}
