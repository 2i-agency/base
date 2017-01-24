<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Commands\ReplaceRN;
use Chunker\Base\Http\Middleware\Redirect;
use Chunker\Base\Providers\Traits\Migrator;
use Illuminate\Contracts\Http\Kernel;
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
	use Migrator;

	/** Корневая папка пакета */
	const ROOT = __DIR__ . '/../..';


	public function boot(Package $package) {
		/** Конфигурация пакета */
		$package
			->setName('base')
			->registerAbilities([

				'notices.edit' => 'Правка уведомлений',

				'notices-types.edit' => 'Редактирование типов уведомлений',
				'notices-types.view' => 'Просмотр типов уведомлений',

				'settings.edit' => 'Редактирование настроек',
				'settings.view' => 'Просмотр настроек',

				'users.edit' => 'Редактирование других пользователей',
				'users.view' => 'Просмотр пользователей',

				'roles.edit' => 'Редактирование ролей',
				'roles.view' => 'Просмотр ролей',

				'redirects.edit' => 'Редактирование перенаправлений',
				'redirects.view' => 'Просмотр перенаправлений',

				'languages.edit' => 'Редактирование языков',
				'languages.view' => 'Просмотр языков',

				'translation.edit' => 'Редактирование перевода интерфейса',
				'translation.view' => 'Просмотр перевода интерфейса',

			])
			->registerAbilitiesViews([
				'base::abilities.notices',
				'base::abilities.notices-types',
				'base::abilities.settings',
				'base::abilities.users',
				'base::abilities.roles',
				'base::abilities.redirects',
				'base::abilities.languages',
				'base::abilities.translation'
			])
			->registerSeeders([
				'BaseAbilitiesSeeder',
				'BaseLanguagesSeeder',
				'BaseSettingsSeeder',
				'BaseUsersAndRolesSeeder'
			]);

		/** Регистрация пакета */
		$this
			->app[ 'Packages' ]
			->register($package);

		/** Установка формата времени по умолчанию */
		Carbon::setToStringFormat('d.m.Y H:i');

		/** Локализация */
		$this->app->setLocale('ru');

		/**
		 * Применение настройек электронной почты
		 *
		 * Беруться из модели Setting
		 * иначе из конфига mail
		 */
		config([
			'mail.driver'       => setting('mail_host') ? 'smtp' : config('mail.driver'),
			'mail.host'         => setting('mail_host') ?: config('mail.host'),
			'mail.port'         => setting('mail_port') ?: config('mail.port'),
			'mail.from.address' => setting('mail_address') ?: config('mail.from.address'),
			'mail.from.name'    => setting('mail_author') ?: config('mail.from.name'),
			'mail.encryption'   => setting('mail_encryption') ?: config('mail.encryption'),
			'mail.username'     => setting('mail_username') ?: config('mail.username'),
			'mail.password'     => setting('mail_password') ?: config('mail.password')
		]);

		/** Замена модели пользователя в конфигурации */
		config([ 'auth.providers.users.model' => User::class ]);

		/** Добавление файлов локализации в пространство имен */
		$this->loadTranslationsFrom(resource_path('lang/vendor/chunker'), 'chunker');

		/** Объявление пространства имён представлений пакета */
		$this->loadViewsFrom(static::ROOT . '/resources/views', 'base');

		/** Регистрация композеров представлений */
		view()->composer('base::template', LanguagesComposer::class);
		view()->composer('base::users.abilities', RolesComposer::class);

		/** Публикация необходимых файлов */
		$path = static::ROOT . '/publishes/';
		$files = array_slice(scandir($path), 2);

		foreach ($files as $file) {
			if ($file == 'database') {

				$this->upMigrates($path . 'database/migrations/', $file);

				$this->publishes([
					$path . 'database/seeds/' => database_path('/seeds/')
				], $file);

			} else {
				$this->publishes([ $path . $file => base_path($file) ], $file);
			}
		}

		/** Регистрация глобального посредника редиректов */
		$this
			->app
			->make(Kernel::class)
			->pushMiddleware(Redirect::class);

		/** Маршруты пакета */
		require_once static::ROOT . '/app/Http/routes/authentication.php';
		require_once static::ROOT . '/app/Http/routes/admin.php';
	}


	public function register() {
		/** Регистрания хелперов */
		foreach (glob(self::ROOT . '/app/Helpers/*.php') as $filename) {
			require_once $filename;
		}

		/** Регистрация команд */
		$this->commands([
			Init::class,
			Seed::class,
			ReplaceRN::class,
		]);

		/** Регистрация классов для работы с пакетами */
		$this->app->bind(Package::class);
		$this->app->singleton('Packages', Manager::class);

		/** Конфигурация группы посредников `admin` */
		$this
			->app[ 'router' ]
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