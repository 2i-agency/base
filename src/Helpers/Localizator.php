<?php

namespace Chunker\Base\Helpers;

use Storage;

class Localizator
{
	protected $disk;


	public function __construct()
	{
		$this->disk = Storage::createLocalDriver(base_path('interface'));
	}


	public function render()
	{

	}
}