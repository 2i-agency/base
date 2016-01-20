<?php

namespace Chunker\Base;

use Chunker\Base\Listeners\UserListener;
use Chunker\Base\Models\Authorization;
use Chunker\Base\Models\Observers\AuthorizationObserver;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	protected $subscribe = [
		UserListener::class,
	];


	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		Authorization::observe(AuthorizationObserver::class);
	}
}