# Базовый пакет Chunker

Пакет предоставляет базовые возможности для веб-приложения на основе [Laravel](https://laravel.com) с конфигурируемой панелью администрирования:

* авторизация и аутентификация пользователей в админцентре;
* настройка учетных записей пользователей и их ролей;
* настройка языков приложения и перевода интерфейса;
* механизм уведомлений пользователей.

## Инсталляция

Установка и обновление пакета происходит через Composer и требует наличия SSH-ключей.

В секцию `require` файла `composer.json` добавляется зависимость `chunker/base`:

```json
"require": {
	"chunker/base": "~2.4"
}
```

В секцию `repositories` добавляется ссылка на [репозиторий пакета](https://bitbucket.org/chunker/base):

```json
"repositories": [
	{
		"type": "vcs",
		"url": "git@bitbucket.org:chunker/base.git"
	}
]
```

После того, как указаны зависимость и репозиторий, необходимо выполнить команду `composer update chunker/base`. Затем в конфигурационном файле Laravel `config/app.php` в массив с сервис-провайдерами следует добавить сервис-провайдеры пакета и его зависимостей:

```php
'providers' => [
	Laracasts\Flash\FlashServiceProvider::class,
	Spatie\MediaLibrary\MediaLibraryServiceProvider::class,

	Chunker\Base\Providers\AppServiceProvider::class,
	Chunker\Base\Providers\EventServiceProvider::class,
];
```

Также в секции с псевдонимами можно заменить стандартный класс `Schema` для работы со структурами таблиц в базе данных на класс из библиотеки [zedisdog/laravel-schema-extend](https://github.com/zedisdog/laravel-schema-extend). Это позволит указывать комментарии для таблиц при миграции.
 
```php
'aliases' => [
	//'Schema' => Illuminate\Support\Facades\Schema::class,
	'Schema' => zedisdog\LaravelSchemaExtend\Schema::class,
]
```

## Инициализация

После того, как сервис-провайдеры пакета добавлены в состав приложения, в Artisan станут доступны команды Chunker. Команда `php artisan chunker:init` производит следующее:

* удаляет коробчные модель `User` и миграции `create_users_table`, `create_password_resets_table`;
* публикует все ассеты пакетов (аналог `php artisan vendor:publish --force`);
* обновляет карту автозагрузки классов (аналог `composer dump-autoload`);
* производит миграцию (аналог `php artisan migrate`).

Также доступна команда `php artisan chunker:seed`, которая запускает посев базового содержимого таблиц, таких как пользователи, языки и так далее. Посевщики таблиц регистрируются в пакетах Chunker, поэтому перед посевом рекомендуется установить все необходимые пакеты приложения.

## Конфигурация

Среди публикуемых ассетов пакета присутствуют файлы конфигурации, которые копируются в папку `config/chunker`. С помощью этих файлов настраивается структура админцентра, локализация и прочие аспекты функционирования Chunker. Описание каждой отдельной опции и примеры настройки можно найти в файлах конфигурации.

## API Tester

Пакет использует библиотеку [asvae/laravel-api-tester](https://github.com/asvae/laravel-api-tester). Она позволяет просматривать маршруты, отправлять на них произвольные запросы и изучать ответы сервера. Панель тестирования находится по адресу `/api-tester` (доступна только в режиме отладки). Перед использованием необходимо зарегистрировать в файле конфигурации сервис-провайдер:

```php
'providers' => [
	Asvae\ApiTester\ServiceProvider::class,
];
```