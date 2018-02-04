<?php

namespace Chunker\Base\Commands;

use Chunker\Base\Commands\Traits\Progressbar;
use Chunker\Base\Models\Media;
use Illuminate\Console\Command;


class ConversionOriginalMedia extends Command
{
	use Progressbar;

	protected $signature = 'chunker:conversion-original';

	protected $description = 'преобразует оригинальные изображения';


	public function handle() {
		/** @var Media $media */
		$media = Media::all();

		if ($media && $media->count()){
			$bar = $this->initProgressbar($media->count(), 1);

			/** @var Media $item */
			foreach ($media as $item) {
				$bar->setMessage($item->id);
				$bar->advance();

				$item->conversionOriginal();
			}

			$this->finishBar($bar);
		}
	}
}