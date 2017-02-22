<?php

namespace Chunker\Base\Providers;

use Chunker\Base\Gate;
use Chunker\Base\Commands\ReplaceRN;
use Chunker\Base\Http\Middleware\Redirect;
use Chunker\Base\Models\Media;
use Chunker\Base\Models\NoticesType;
use Chunker\Base\Models\Role;
use Chunker\Base\Models\Setting;
use Chunker\Base\Providers\Traits\Migrator;
use Chunker\Base\ViewComposers\ActivityLogComposer;
use Chunker\Base\ViewComposers\VisibleRoleComposer;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use Chunker\Base\Packages\Manager;
use Chunker\Base\Packages\Package;
use Chunker\Base\Commands\Init;
use Chunker\Base\Commands\Seed;
use Chunker\Base\Models\User;
use Chunker\Base\ViewComposers\LanguagesComposer;
use Chunker\Base\ViewComposers\RolesComposer;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use zedisdog\LaravelSchemaExtend\Schema;
use Chunker\Base\Models\Redirect as ModelRedirect;

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

				'notices-types.admin' => 'Администрирование типов уведомлений',
				'notices-types.edit'  => 'Редактирование типов уведомлений',
				'notices-types.view'  => 'Просмотр типов уведомлений',

				'settings.edit' => 'Редактирование настроек',
				'settings.view' => 'Просмотр настроек',

				'users.admin' => 'Администрирование пользователей',
				'users.edit'  => 'Редактирование других пользователей',
				'users.view'  => 'Просмотр пользователей',

				'roles.admin' => 'Администрирование ролей',
				'roles.edit'  => 'Редактирование ролей',
				'roles.view'  => 'Просмотр ролей',

				'redirects.admin' => 'Администрирование перенаправлений',
				'redirects.edit'  => 'Редактирование перенаправлений',
				'redirects.view'  => 'Просмотр перенаправлений',

				'languages.edit' => 'Редактирование языков',
				'languages.view' => 'Просмотр языков',

				'translation.edit' => 'Редактирование перевода интерфейса',
				'translation.view' => 'Просмотр перевода интерфейса',

				'activity-log.view' => 'Просмотр аудита',
			])
			->registerAbilitiesViews([
				'base::abilities.notices',
				'base::abilities.notices-types',
				'base::abilities.settings',
				'base::abilities.users',
				'base::abilities.roles',
				'base::abilities.redirects',
				'base::abilities.languages',
				'base::abilities.translation',
				'base::abilities.activity-log'
			])
			->registerSeeders([
				'BaseAbilitiesSeeder',
				'BaseLanguagesSeeder',
				'BaseSettingsSeeder',
				'BaseUsersAndRolesSeeder'
			])
			->registerMenuItems([
				'users'         => [
					'name'   => 'Пользователи',
					'icon'   => 'users',
					'route'  => 'admin.users',
					'policy' => 'users.view'
				],
				'roles'         => [
					'name'   => 'Роли',
					'icon'   => 'star',
					'route'  => 'admin.roles',
					'policy' => 'roles.view'
				],
				'redirects'     => [
					'name'   => 'Перенаправления',
					'icon'   => 'exchange',
					'route'  => 'admin.redirects',
					'policy' => 'redirects.view'
				],
				'notices-types' => [
					'name'   => 'Типы уведомлений',
					'icon'   => 'envelope',
					'route'  => 'admin.notices-types',
					'policy' => 'notices-types.view'
				],
				'settings'      => [
					'name'   => 'Настройки',
					'icon'   => 'sliders',
					'route'  => 'admin.settings',
					'policy' => 'settings.view'
				],
				'activity-log'  => [
					'name'   => 'Аудит действий',
					'icon'   => 'info',
					'route'  => 'admin.activity-log',
					'policy' => 'activity-log.view'
				]
			])
			->registerActivityElements([
				//				User::class          => 'base::entities.user',
				Role::class          => 'base::entities.role',
				ModelRedirect::class => 'base::entities.redirect',
				NoticesType::class   => 'base::entities.notice-type',
				Setting::class       => 'base::entities.setting'
			]);

		/** Регистрация пакета */
		$this
			->app[ 'Packages' ]
			->register($package);

		/** Установка формата времени по умолчанию */
		Carbon::setToStringFormat('d.m.Y H:i');

		/** Установка лимита на размер загружамего файла в Media */
		config([ 'laravel-medialibrary.max_file_size' => UploadedFile::getMaxFilesize() ]);

		/** Локализация */
		$this->app->setLocale('ru');

		/** Заменяем стандартный класс Gate */
		config([ 'app.aliases.Gate' => Gate::class ]);

		/** Заменяем стандартый класс Schema */
		config([ 'app.aliases.Schema' => Schema::class ]);


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
		$this->loadTranslationsFrom(static::ROOT . '/resources/lang', 'base');

		/** Объявление пространства имён представлений пакета */
		$this->loadViewsFrom(static::ROOT . '/resources/views', 'base');

		/** Регистрация композеров представлений */
		view()->composer('base::template', LanguagesComposer::class);
		view()->composer('base::users.list', VisibleRoleComposer::class);
		view()->composer([
			'base::activity-log.table',
			'base::activity-log.filter',
		], ActivityLogComposer::class);
		view()->composer([
			'base::users.abilities',
			'base::roles.form'
		], RolesComposer::class);

		/** Публикация необходимых файлов */
		$this->publish(static::ROOT . '/publishes/');

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

		/** Регистрация кастомного Gate */
		$this->app->singleton(GateContract::class, function($app) {
			return new Gate($app, function() use ($app) {
				return call_user_func($app[ 'auth' ]->userResolver());
			});
		});

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