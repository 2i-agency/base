<?php

namespace Chunker\Admin;

use Chunker\Admin\Listeners\UserListener;
use Chunker\Admin\Models\Authorization;
use Chunker\Admin\Models\Observers\AuthorizationObserver;
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