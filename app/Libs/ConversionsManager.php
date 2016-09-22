<?php

namespace Chunker\Base\Libs;


class ConversionsManager
{
	public static function getConversion($name){
		$conversions = config('chunker.conversions.templates');
		$default = array_pull($conversions, 'default');

		if (is_null($default)){
			$default = [];
		}

		return array_merge($default, $conversions[$name]);
	}
}