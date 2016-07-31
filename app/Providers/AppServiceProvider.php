<?php

namespace Chunker\Base\Providers;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Chunker\Base\Packages\Manager;
use Chunker\Base\Packages\Package;
use Chunker\Base\Commands\Init;
use Chunker\Base\Commands\Seed;
use Chunker\Base\Models\User;
use Chunker\Base\ViewComposers\LanguagesComposer;
use Chunker\Base\ViewComposers\RolesComposer;

class AppServiceProvider extends ServiceProvider
{
	// Корневая папка пакета
	const ROOT = __DIR__ . '/../..';


	public function boot(Package $package) {
		// Конфигурация пакета
		$package
			->setName('base')
			->registerAbilities([

				'admin.access'      => 'Доступ в админцентр',

				'notices.view'      => 'Просмотр уведомлений',
				'notices.edit'      => 'Правка уведомлений',

				'users.view'        => 'Просмотр пользователей',
				'users.add'         => 'Добавление пользователей',
				'users.edit'        => 'Правка пользователей',

				'roles.view'        => 'Просмотр ролей',
				'roles.add'         => 'Добавление ролей',
				'roles.edit'        => 'Правка ролей',

				'settings.view'     => 'Просмотр настроек',
				'settings.edit'     => 'Правка настроек',

				'languages.view'    => 'Просмотр языков',
				'languages.add'     => 'Добавление языков',
				'languages.edit'    => 'Правка языков',

				'translation.view'  => 'Просмотр перевода интерфеса',
				'translation.edit'  => 'Правка перевода интерфейса',

			])
			->registerAbilitiesViews([
				'chunker.base::admin.abilities.admin',
				'chunker.base::admin.abilities.notices',
				'chunker.base::admin.abilities.users',
				'chunker.base::admin.abilities.roles',
				'chunker.base::admin.abilities.settings',
				'chunker.base::admin.abilities.languages',
				'chunker.base::admin.abilities.translation'
			]);


		// Регистрация пакета
		$this
			->app['Packages']
			->register($package);


		// Локализация
		Carbon::setToStringFormat('d.m.Y H:i:s');
		$this->app->setLocale('ru');


		// Настройка электронной почты
		config([
			'mail.driver'       => setting('mail_host')         ? 'smtp' : config('mail.driver'),
			'mail.host'         => setting('mail_host')         ?: config('mail.host'),
			'mail.port'         => setting('mail_port')         ?: config('mail.port'),
			'mail.from.address' => setting('mail_address')      ?: config('mail.from.address'),
			'mail.from.name'    => setting('mail_author')       ?: config('mail.from.name'),
			'mail.encryption'   => setting('mail_encryption')   ?: config('mail.encryption'),
			'mail.username'     => setting('mail_username')     ?: config('mail.username'),
			'mail.password'     => setting('mail_password')     ?: config('mail.password')
		]);


		// Замена модели пользователя в конфигурации
		config(['auth.providers.users.model' => User::class]);


		// Добавление файлов локализации в пространство имен
		$this->loadTranslationsFrom(resource_path('lang/vendor/chunker'), 'chunker');


		// Команды
		$this->commands([
			Init::class,
			Seed::class,
		]);


		// Шаблоны и композеры
		$this->loadViewsFrom(static::ROOT . '/resources/views', 'chunker.base');
		view()->composer('chunker.base::admin.template', LanguagesComposer::class);
		view()->composer('chunker.base::admin.users._form', RolesComposer::class);


		// Публикация ассетов
		$this->publishes([static::ROOT . '/config' => config_path('chunker')], 'config');

		$this->publishes([static::ROOT . '/resources/lang' => base_path('resources/lang')], 'lang');

		$this->publishes([
			static::ROOT . '/database/migrations'   => database_path('migrations'),
			static::ROOT . '/database/seeds'        => database_path('seeds')
		], 'database');

		$this->publishes([
			static::ROOT . '/public/admin'      => public_path('admin'),
			static::ROOT . '/public/.htaccess'  => public_path('.htaccess'),
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


	public function register() {
		// Подключение хелперов
		foreach (glob(self::ROOT . '/app/Helpers/*.php') as $filename) {
			require_once $filename;
		}

		// Пакет
		$this->app->bind('Package', function() {
			return new Package;
		});

		// Менеджер пакетов
		$this->app->singleton('Packages', function() {
			return new Manager;
		});
	}
}