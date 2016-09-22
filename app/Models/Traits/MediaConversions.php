<?php

namespace Chunker\Base\Models\Traits;


use Chunker\Base\Libs\ConversionsManager;

trait MediaConversions
{
	/*
	 * Возвращает список конверсий
	 */
	public function getConversionsList()
	{

		// Если список конверсий определён, то брать его, иначе брать список всех конверсий
		if (isset($this->conversions_config))
			$conversions = config($this->conversions_config);
		else {
			$conversions = config('chunker.formats-conversions.conversions');
			$conversions = array_except($conversions, 'default');
		}

		$manipulations = [];

		foreach ($conversions as $key => $conversion) {
			if (is_int($key)) {
				$manipulations[$conversion] = ConversionsManager::getConversion($conversion);
			} else {
				$manipulations[$key] = $conversion;
			}
		}
		return $manipulations;
	}


	/*
	 * Метод создающий превью для загружаемых изображений.
	 */
	public function registerMediaConversions()
	{
		$manipulations = $this->getConversionsList();

		foreach ($manipulations as $name => $params) {
			$this->addMediaConversion($name)
				->setManipulations($params)
				->performOnCollections()
				->nonQueued();
		}
	}
}
