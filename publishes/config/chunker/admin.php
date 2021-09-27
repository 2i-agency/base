<?php

return [

	/**
	 *--------------------------------------------------------------------------
	 * Префикс админцентра
	 *--------------------------------------------------------------------------
	 *
	 * Часть URL, которая следует сразу после адреса сайта и позволяет получить
	 * доступ в админцентр.
	 *
	 */
	'prefix'    => 'admin',


	'notice-observer' => Chunker\Base\Observers\NoticeObserver::class,
	/**
	 *--------------------------------------------------------------------------
	 * Структура меню
	 *--------------------------------------------------------------------------
	 *
	 * Каждый элемент меню представлен массивом. Доступные ключи:
	 * `name`        — название, которое используется в меню;
	 * `icon`        — иконка из набора FontAwesome, без префиксов `fa`;
	 * `children`    — массив элементов вложенного меню;
	 * `route`       — имя маршрута, на который ссылается элемент;
	 * `policy`      — правило авторизации, которая определяет наличие доступа
	 *                 у пользователя к разделу.
	 *
	 * Если для ключа `children` вместо вложенного массива использовать пустую
	 * строку, то будет создан разделитель.
	 *
	 */
	'structure' => [
		[
			'name'     => 'Контент',
			'icon'     => 'database',
			'children' => [
//				'articles',
//				'articles-categories',
//				'',
//				'news',
//				'news-rubrics',
//				'',
//				'events',
//				'events-categories',
//				'',
//				'banners',
//				'banners-categories',
//				'banners-places',
//				'',
//				'grids',
//				'',
//				'houses-projects',
//				'houses-projects-categories',
//				'houses-projects-types',
//				'houses-projects-technologies',
//				'houses-projects-complectations',
//				'',
//				'reviews',
//				'',
//				'privacy-policy',
//				'',
//				'realty-offers',
//				'realty-sellers'
			]
		],
		[
			'name' => 'Магазин',
			'icon' => 'shopping-cart',
			'children' => [
//				'products',
//				'products-groups',
//				'products-categories',
//				'',
//				'orders'
			]
		],
		[
			'name'     => 'Предприятие',
			'icon'     => 'university',
			'children' => [
//				'contractors',
//				'contractors-categories',
//				'activity-scopes',
//				'ad-sources'
			]
		],
//		'mediamanager',
		[
			'name' => 'Дизайн',
			'icon' => 'magic',
			'children' => [
//				'structure',
//				'communities',
			]
		],
		[
			'name'     => 'Система',
			'icon'     => 'cogs',
			'children' => [
				'users',
				'roles',
				'',
				'redirects',
				'',
				'notices-types',
				'settings',
				'',
				'activity-log',
//				'',
//				'backups',
			]
		]
	],

	/**
	 *--------------------------------------------------------------------------
	 * Дополнительные ссылки в админцентре
	 *--------------------------------------------------------------------------
	 *
	 * Каждая ссыла обязательно содержит ключи с названием и URL. Ключ с иконкой
	 * опционален.
	 *
	 */
	'links'     => [
		[
			'name' => 'Сайт',
			'url'  => env('APP_URL', '/'),
			'icon' => 'book'
		]
	],


	/**
	 *--------------------------------------------------------------------------
	 * Подключаемые в редактор js и ccs файлы для точного отображения текста
	 *--------------------------------------------------------------------------
	 *
	 * css - Пути к CSS-файлам для предпросмотра в редакторе
	 * js  - Пути к JS-файлам для имитации поведения реальной страницы
	 */
	'editor'    => [
		'css'     => [
			'https://yastatic.net/bootstrap/3.3.6/css/bootstrap.min.css'
		],
		'js'      => [
			'https://yastatic.net/jquery/2.2.0/jquery.min.js',
			'https://yastatic.net/bootstrap/3.3.6/js/bootstrap.min.js'
		],
		'tinymce' => true
	],


	/**
	 *--------------------------------------------------------------------------
	 * Структура раздела настроек
	 *--------------------------------------------------------------------------
	 *
	 * На первом уровне — идентификатор страницы, используется для формирования
	 * маршрута. На втором уровне указываются название, иконка и опции,
	 * представленные на странице.
	 *
	 */
	'settings'  => [
		'site' => [
			'name'    => 'Сайт',
			'icon'    => 'bookmark',
			'options' => [
				'site_name',
				'site_name',
				'meta_title',
				'meta_keywords',
				'meta_description',
			]
		],
		'mail' => [
			'name'    => 'Электронная почта',
			'icon'    => 'envelope',
			'options' => [
				'mail_address',
				'mail_author',
				'mail_host',
				'mail_port',
				'mail_username',
				'mail_password',
				'mail_encryption'
			]
		]
	]

];