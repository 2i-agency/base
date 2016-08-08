<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Listeners\UserListener;
use Chunker\Base\Models\Authentication;
use Chunker\Base\Models\Language;
use Chunker\Base\Models\Notice;
use Chunker\Base\Models\NoticesType;
use Chunker\Base\Models\Observers\NoticesTypeObserver;
use Chunker\Base\Models\Role;
use Chunker\Base\Models\Observers\AuthenticationObserver;
use Chunker\Base\Models\Observers\LanguageObserver;
use Chunker\Base\Models\Observers\NoticeObserver;
use Chunker\Base\Models\Observers\RoleObserver;
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
		Notice::observe(NoticeObserver::class);
		NoticesType::observe(NoticesTypeObserver::class);
		Role::observe(RoleObserver::class);
	}
}