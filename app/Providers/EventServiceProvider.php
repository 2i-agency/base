<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Listeners\MediaListener;
use Chunker\Base\Listeners\UserListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Spatie\MediaLibrary\Events\MediaHasBeenAdded;

class EventServiceProvider extends ServiceProvider
{
	/** @var array Слушатели событий */
	protected $subscribe = [
		UserListener::class,
	];

	protected $listen = [
		MediaHasBeenAdded::class => [
			MediaListener::class
		],
	];
}