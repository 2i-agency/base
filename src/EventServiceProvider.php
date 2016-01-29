<?php

namespace Chunker\Base;

use Chunker\Base\Listeners\UserListener;
use Chunker\Base\Models\Authorization;
use Chunker\Base\Models\Observers\AuthorizationObserver;
use Chunker\Base\Models\Observers\EditorObserver;
use Chunker\Base\Models\User;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	// Регистрация слушателей событий
	protected $subscribe = [
		UserListener::class,
	];


	public function boot(DispatcherContract $events)
	{
		parent::boot($events);

		// Регистрация наблюдателей моделей
		Authorization::observe(AuthorizationObserver::class);
		User::observe(EditorObserver::class);
	}
}