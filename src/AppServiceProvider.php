<?php

namespace Chunker\Base;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function boot()
	{
		// Configuration of time string
		Carbon::setToStringFormat('d.m.Y H:i:s');


		// Commands
		$this->commands([
			Commands\Init::class
		]);


		// Middlewares
		$this
			->app['router']
			->middlewareGroup('admin', [
				\App\Http\Middleware\EncryptCookies::class,
				\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
				\Illuminate\Session\Middleware\StartSession::class,
				\Illuminate\View\Middleware\ShareErrorsFromSession::class,
				\App\Http\Middleware\VerifyCsrfToken::class,
				\Chunker\Base\Middleware\CheckAuth::class,
			]);


		// Routes
		require_once __DIR__ . '/routes.php';


		// Views
		$this->loadViewsFrom(__DIR__ . '/resources/views', 'Base');


		// Publishing assets
		$this->publishes([
			__DIR__ . '/assets/config' => config_path(),
			__DIR__ . '/assets/migrations' => database_path('migrations'),
			__DIR__ . '/assets/seeds' => database_path('seeds'),
			__DIR__ . '/assets/css' => storage_path('app/admin/css'),
			__DIR__ . '/assets/js' => storage_path('app/admin/js')
		], 'assets');


		// Publishing parts of app
		$this->publishes([
			__DIR__ . '/resources/views' => base_path('resources/views/admin'),
			__DIR__ . '/resources/styles' => base_path('resources/assets/styles'),
			__DIR__ . '/Commands' => app_path('Console/Commands'),
			__DIR__ . '/Controllers' => app_path('Http/Controllers'),
			__DIR__ . '/Middleware' => app_path('Http/Middleware'),
			__DIR__ . '/Models' => app_path('Models'),
		], 'app');
	}


	public function register()
	{
		//
	}
}