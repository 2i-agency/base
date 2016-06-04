<?php

namespace Chunker\Base\Helpers;

use Storage;

class Localizator
{
	protected $disk;


	public function __construct() {
		$this->disk = Storage::createLocalDriver(['root' => base_path('resources/interface')]);
	}


	/*
	 * Запись данных локализации в файл
	 */
	public function writeSection($data = [], $locale = NULL) {
		dd($locale, $data);
	}
}