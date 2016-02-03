<?php

namespace Chunker\Base;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	public function boot()
	{
		// Настройка форматирования времени по умолчанию
		Carbon::setToStringFormat('d.m.Y H:i:s');


		// Команды пакета
		$this->commands([
			Commands\Init::class
		]);


		// Шаблоны пакета
		$this->loadViewsFrom(__DIR__ . '/resources/views', 'Base');


		// Настройка публикации сопутствующих файлов пакета
		$this->publishes([
			__DIR__ . '/assets/config' => config_path(),
			__DIR__ . '/assets/migrations' => database_path('migrations'),
			__DIR__ . '/assets/seeds' => database_path('seeds'),
			__DIR__ . '/assets/css' => storage_path('app/admin/css'),
			__DIR__ . '/assets/js' => storage_path('app/admin/js'),
			__DIR__ . '/assets/img' => storage_path('app/admin/img')
		]);


		// Конфигурация группы посредников `admin`
		// TODO Избавить админцентр от CSRF-защиты
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


		// Маршруты пакета
		require_once __DIR__ . '/routes/authorization.php';
		require_once __DIR__ . '/routes/admin.php';
	}


	public function register() {}
}