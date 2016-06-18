<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Listeners\UserListener;
use Chunker\Base\Models\Authentication;
use Chunker\Base\Models\Language;
use Chunker\Base\Models\Observers\AuthenticationObserver;
use Chunker\Base\Models\Observers\LanguageObserver;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
	// Регистрация слушателей событий
	protected $subscribe = [
		UserListener::class,
	];


	public function boot(DispatcherContract $events) {
		parent::boot($events);

		// Регистрация наблюдателей моделей
		Authentication::observe(AuthenticationObserver::class);
		Language::observe(LanguageObserver::class);
	}
}