<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Http\Middleware\Redirect;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
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

				'notices.edit'          => 'Правка уведомлений',

				'notices-types.edit'    => 'Редактирование типов уведомлений',
				'notices-types.view'    => 'Просмотр типов уведомлений',

				'settings.edit'         => 'Редактирование настроек',
				'settings.view'         => 'Просмотр настроек',

				'users.edit'            => 'Редактирование других пользователей',
				'users.view'            => 'Просмотр пользователей',

				'roles.edit'            => 'Редактирование ролей',
				'roles.view'            => 'Просмотр ролей',

				'redirects.edit'        => 'Редактирование перенаправлений',
				'redirects.view'        => 'Просмотр перенаправлений',

				'languages.edit'        => 'Редактирование языков',
				'languages.view'        => 'Просмотр языков',

				'translation.edit'      => 'Редактирование перевода интерфейса',
				'translation.view'      => 'Просмотр перевода интерфейса',

			])
			->registerAbilitiesViews([
				'chunker.base::admin.abilities.notices',
				'chunker.base::admin.abilities.notices-types',
				'chunker.base::admin.abilities.settings',
				'chunker.base::admin.abilities.users',
				'chunker.base::admin.abilities.roles',
				'chunker.base::admin.abilities.redirects',
				'chunker.base::admin.abilities.languages',
				'chunker.base::admin.abilities.translation'
			])
			->registerSeeders([
				'BaseAbilitiesSeeder',
				'BaseLanguagesSeeder',
				'BaseSettingsSeeder',
				'BaseUsersAndRolesSeeder'
			]);


		// Регистрация пакета
		$this
			->app['Packages']
			->register($package);


		// Локализация
		Carbon::setToStringFormat('d.m.Y H:i');
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

		// Публикация миграции для пакета MediaLibrary
		if ($this->app instanceof LaravelApplication) {

			if (! class_exists('AddTreeToMedia')) {

				$timestamp = date('Y_m_d_His', (time() + 1));
				
				$this->publishes([
					self::ROOT . '/database/stub/add_tree_to_media.php.stub' => database_path('migrations/'.$timestamp.'_add_tree_to_media.php'),
				], 'migrations');
			}

		}

		$this->publishes([
			static::ROOT . '/public/admin'      => public_path('admin'),
			static::ROOT . '/public/.htaccess'  => public_path('.htaccess'),
		], 'public');

		$this->publishes([
			static::ROOT . '/assets/routes.php' => app_path('Http/routes.php')
		], 'app');


		// Регистрация глобального посредника редиректов
		$this
			->app
			->make(Kernel::class)
			->pushMiddleware(Redirect::class);


		// Маршруты пакета
		require_once static::ROOT . '/app/Http/routes/authentication.php';
		require_once static::ROOT . '/app/Http/routes/admin.php';
	}


	public function register() {
		// Хелперы
		foreach (glob(self::ROOT . '/app/Helpers/*.php') as $filename) {
			require_once $filename;
		}

		// Команды
		$this->commands([
			Init::class,
			Seed::class,
		]);

		// Пакет и менеджер пакетов
		$this->app->bind(Package::class);
		$this->app->singleton('Packages', Manager::class);

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
	}
}