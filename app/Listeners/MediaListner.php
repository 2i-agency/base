<?php

namespace Chunker\Base\Listeners;

use Spatie\MediaLibrary\Events\MediaHasBeenAdded;


class MediaListener
{
	public function handle(MediaHasBeenAdded $event) {
		$event->media->conversionOriginal();
	}
}
