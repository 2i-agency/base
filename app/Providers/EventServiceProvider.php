<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Listeners\UserListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	/** @var array Слушатели событий */
	protected $subscribe = [
		UserListener::class,
	];
}