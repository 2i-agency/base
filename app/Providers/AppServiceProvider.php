<?php

namespace Chunker\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Chunker\Base\Commands\Init;
use Chunker\Base\Models\User;
use Chunker\Base\ViewComposers\LanguagesComposer;

class AppServiceProvider extends ServiceProvider
{
	// Корневая папка пакета
	const ROOT = __DIR__ . '/../..';


	public function boot()
	{
		// Форматирование времени по умолчанию
		Carbon::setToStringFormat('d.m.Y H:i:s');


		// Замена модели пользователя в конфигурации
		config(['auth.providers.users.model' => User::class]);


		// Добавление файлов локализации в пространство имен
		$this->loadTranslationsFrom(resource_path('lang/vendor/chunker'), 'chunker');


		// Команды
		$this->commands([ Init::class ]);


		// Шаблоны и композеры
		$this->loadViewsFrom(static::ROOT . '/resources/views', 'chunker.base');
		view()->composer('chunker.base::admin.template', LanguagesComposer::class);


		// Публикация ассетов
		$this->publishes([static::ROOT . '/config' => config_path('chunker')], 'config');

		$this->publishes([static::ROOT . '/resources/lang' => base_path('resources/lang')]);

		$this->publishes([
			static::ROOT . '/database/migrations' => database_path('migrations'),
			static::ROOT . '/database/seeds' => database_path('seeds')
		], 'database');

		$this->publishes([
			static::ROOT . '/public/admin' => public_path('admin'),
			static::ROOT . '/public/.htaccess' => public_path('.htaccess'),
		], 'public');


		// Конфигурация группы посредников `admin`
		$this
			->app['router']
			->middlewareGroup('admin', [
				\App\Http\Middleware\EncryptCookies::class,
				\Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
				\Illuminate\Session\Middleware\StartSession::class,
				\Illuminate\View\Middleware\ShareErrorsFromSession::class,
				\Chunker\Base\Http\Middleware\CheckAuth::class,
				\Chunker\Base\Http\Middleware\SetLocale::class,
			]);


		// Маршруты пакета
		require_once static::ROOT . '/app/Http/routes/authentication.php';
		require_once static::ROOT . '/app/Http/routes/admin.php';
	}


	public function register() {}
}