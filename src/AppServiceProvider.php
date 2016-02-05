<?php

namespace Chunker\Base;

use Carbon\Carbon;
use Chunker\Base\ViewComposers\LanguagesComposer;
use Illuminate\Support\ServiceProvider;
use Chunker\Base\Models\User;

class AppServiceProvider extends ServiceProvider
{
	public function boot()
	{
		// Настройка форматирования времени по умолчанию
		Carbon::setToStringFormat('d.m.Y H:i:s');


		// Конфигурация приложения
		config([
			'app.timezone' => 'Europe/Moscow',
			'auth.providers.users.model' => User::class
		]);


		// Команды пакета
		$this->commands([
			Commands\Init::class
		]);


		// Шаблоны пакета и локализация интерфейса сайта
		$this->loadViewsFrom(__DIR__ . '/resources/views', 'Base');
		$this->loadTranslationsFrom(base_path('resources/interface'), 'Base');


		// Регистрация композеров шаблонов
		view()->composer('Base::template', LanguagesComposer::class);


		// Настройка публикации сопутствующих файлов пакета
		$this->publishes([
			__DIR__ . '/assets/config' => config_path(),
			__DIR__ . '/assets/migrations' => database_path('migrations'),
			__DIR__ . '/assets/seeds' => database_path('seeds'),
			__DIR__ . '/assets/css' => storage_path('app/admin/css'),
			__DIR__ . '/assets/js' => storage_path('app/admin/js'),
			__DIR__ . '/assets/img' => storage_path('app/admin/img'),
			__DIR__ . '/resources/lang' => base_path('resources/lang')
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
				\Chunker\Base\Middleware\SetLocale::class,
			]);


		// Маршруты пакета
		require_once __DIR__ . '/routes/authorization.php';
		require_once __DIR__ . '/routes/admin.php';
	}


	public function register() {}
}