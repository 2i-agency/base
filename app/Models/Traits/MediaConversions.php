<?php

namespace Chunker\Base\Models\Traits;

use Chunker\Base\Libs\ConversionsManager;

/**
 * Трейт для работы c конверсиями
 *
 * @package Chunker\Base\Models\Traits
 */
trait MediaConversions
{

	/**
	 * Метод создающий превью для загружаемых изображений
	 */
	public function registerMediaConversions(){
		$manipulations = ConversionsManager::getConversionsList($this->conversions_config);

		foreach ($manipulations as $name => $params) {
			$this->addMediaConversion($name)
				->setManipulations($params)
				->performOnCollections()
				->nonQueued();
		}
	}
}
