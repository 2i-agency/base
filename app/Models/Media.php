<?php

namespace Chunker\Base\Models;

use Chunker\Base\Libs\ConversionsManager;
use Kalnoy\Nestedset\NodeTrait;
use Spatie\Glide\GlideImage;
use Spatie\MediaLibrary\Media as BaseMedia;

/**
 * Расширение модели *Spatie\MediaLibrary\Media*
 * для добавления *NodeTrait* и фильтрации атрибутов
 *
 * @package Chunker\Base\Commands
 */
class Media extends BaseMedia
{
	use NodeTrait;

	/** @var string имя таблицы */
	protected $table = 'media';


	public function conversionOriginal() {
		$conversion = config('chunker.conversions.original');

		if (is_string($conversion)) {
			$manipulations = ConversionsManager::getConversion($conversion);
		} else {
			$manipulations = $conversion;
		}

		if ($this->getTypeAttribute() == 'image') {
			GlideImage::create($this->getPath())
				->modify($manipulations)
				->save($this->getPath());
		}
	}


	/**
	 * Метод необходим для фильтрации элементов
	 *
	 * @return array
	 */
	protected function getScopeAttributes(){
		return [ 'model_id', 'model_type', 'collection_name' ];
	}
}
