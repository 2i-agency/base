# Базовый пакет Chunker

Пакет предоставляет базовые возможности для веб-приложения на основе [Laravel](https://laravel.com) с панелью администрирования:

* авторизация и аутентификация пользователей в админцентре;
* настройка учетных записей пользователей и их ролей;
* настройка языков приложения и перевода интерфейса;
* механизм уведомлений пользователей.

## Инсталляция

Установка и обновление пакета происходит через Composer и требует наличия SSH-ключей.

В секцию `require` файла `composer.json` добавляется зависимость `chunker/base`:

```json
"require": {
	"chunker/base": "~2.*"
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

После того, как указаны зависимость и репозиторий, необходимо выполнить команду `composer update chunker/base`. Затем в конфигурационном файле Laravel `config/app.php` в массив с сервис-провайдерами следует добавить сервис-провайдеры пакета:

```php
'providers' => [
	Chunker\Base\AppServiceProvider::class,
	Chunker\Base\EventServiceProvider::class,
];
```

## Инициализация

После того, как сервис-провайдеры пакета добавлены в состав приложения, в Artisan станут доступны команды Chunker. Команда `php artisan chunker:init` производит следующее:

* удаляет коробчные модель `User` и миграции `create_users_table`, `create_password_resets_table`;
* публикует все ассеты пакетов (аналог `php artisan vendor:publish --force`);
* обновляет карту автозагрузки классов (аналог `composer dump-autoload`);
* запускает миграцию (аналог `php artisan migrate`).

Также доступна команда `php artisan chunker:seed`, которая запускает посев базового содержимого таблиц, таких как пользователи, языки и так далее.